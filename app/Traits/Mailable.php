<?php

namespace App\Traits;

use App\Mail\EmailSendWithBlade;
use App\Mail\EmailSendWithBladeAttach;
use App\Models\EmailFormat;
use App\Models\EmailHistory;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;

trait Mailable
{
    public static function sendEmailCommonCode($template, $user, $order = null, $adminEmail = null, $extraLegendValues = null, $voucher = null, $link = null)
    {
        // Get the appropriate email template based on the type
        $emailTemplate = self::getEmailTemplate($template);

        if ($emailTemplate) {
            // Set up modelArray based on the presence of an order
            $modelArray = ['users' => $user];
            // Set default extraLegendValues based on the type
            $defaultExtraLegendValues = [
                config('constants.email_template.common_lagends.admin_login_url') => config('app.url'),
            ];
            // Merge default and provided extraLegendValues
            $extraLegendValues = array_merge($defaultExtraLegendValues, $extraLegendValues ?? []);

            // Get subject and body with dynamic content
            $subject = User::getDynamicContent($emailTemplate->subject, $modelArray, $extraLegendValues);
            $emailBody = User::getDynamicContent($emailTemplate->body, $modelArray, $extraLegendValues);

            // Determine recipient email
            $recipientEmail = $adminEmail ?? $user->email;

            // Send email
            self::sendMail($recipientEmail, $subject, $emailBody, null, $link);
        }
    }

    /**
     * Send Import Success Email
     */
    public static function sendImportEmail($template, $extraLegendValues, $link, $user)
    {
        $emailTemplate = Mailable::getEmailTemplate($template);

        if ($emailTemplate) {
            $modelArray = null;
            $emailSubject = User::getDynamicContent($emailTemplate->subject, $modelArray, $extraLegendValues);
            $emailBody = User::getDynamicContent($emailTemplate->body, $modelArray, $extraLegendValues);
            Mailable::sendMail($user->email, $emailSubject, $emailBody, null, $link, null);
        }
    }

    /**
     * Send Import Success Email
     */
    public static function sendImportSuccess($model, $extraLegendValues = null, $link = null)
    {
        $emailTemplate = Mailable::getEmailTemplate(config('constants.email_template.type.import_success'));

        if ($emailTemplate) {
            $modelArray = null;
            $emailSubject = User::getDynamicContent($emailTemplate->subject, $modelArray, $extraLegendValues);
            $emailBody = User::getDynamicContent($emailTemplate->body, $modelArray, $extraLegendValues);
            Mailable::sendMail(config('constants.import_csv_log.import_email_recipients'), null, $emailSubject, $emailBody, null, $link);
        }
    }

    /**
     * Send Import Fail Email
     */
    public static function sendImportFail($model, $extraLegendValues = null, $link = null)
    {
        $emailTemplate = Mailable::getEmailTemplate(config('constants.email_template.type.import_fail'));

        if ($emailTemplate) {
            $modelArray = null;
            $emailSubject = User::getDynamicContent($emailTemplate->subject, $modelArray, $extraLegendValues);
            $emailBody = User::getDynamicContent($emailTemplate->body, $modelArray, $extraLegendValues);
            Mailable::sendMail(config('constants.import_csv_log.import_email_recipients'), null, $emailSubject, $emailBody, null, $link);
        }
    }


    /**
     * Prepare & Send mail, also store the email history
     *
     * @param $toEmails
     * @param $ccEmails
     * @param $subject
     * @param $body
     * @param null $attachment
     *
     * @throws \ReflectionException
     */
    public static function sendMail($toEmails, $ccEmails, $subject, $body, $attachment = null, $link = null, $loginLink = null, $isEmailOtp = false)
    {
        $completeBody = [
            'header' => self::getEmailFormat(config('constants.email_format.type.header')),
            'body' => $body,
            'signature' => self::getEmailFormat(config('constants.email_format.type.signature')),
            'footer' => self::getEmailFormat(config('constants.email_format.type.footer')),
            'link' => $link,
            'login_link' => $loginLink,
        ];

        $html = (new EmailSendWithBlade($subject, $completeBody))->render();

        if (App::environment(['production'])) {
            if (is_null($attachment)) {
                Mail::to($toEmails)->send(new EmailSendWithBlade($subject, $completeBody));
            } else {
                Mail::to($toEmails)->send(new EmailSendWithBladeAttach($subject, $completeBody, $attachment));
            }
        }

        EmailHistory::storeHistory($toEmails, $ccEmails, $subject, $html);
    }

    /**
     * @param $type
     * @return string
     */
    public static function getEmailFormat($type)
    {
        $emailFormat = EmailFormat::where('type', $type)->first();
        if (!is_null($emailFormat)) {
            return $emailFormat->body;
        }

        return '';
    }

    /**
     * @param $type
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function getEmailTemplate($type)
    {
        return EmailTemplate::where('type', $type)
            ->first();
    }
}
