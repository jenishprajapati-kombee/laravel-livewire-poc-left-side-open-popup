<?php

return [
  'image' => 
  [
    'view_image' => 'View Image',
    'view_attachment' => 'View Attachment',
    'download_attachment' => 'Download Attachment',
  ],
  'maximum_record_limit_error' => 'You can add a maximum of 5 records only.',
  'common_error_message' => 'Something went wrong. Please try again after some time.',
  'login' => 
  [
    'success' => 'Login is successful.',
    'unverified_account' => 'Your account is not verified yet.',
    'wrong_credentials' => 'Invalid combination of email and password.',
    'forgot_password_success' => 'Password reset instructions has been sent to your email. Please check your inbox/spam',
    'reset_password_success' => 'Your password has been reset successfully.',
    'change_password_success' => 'Your password has changed successfully.',
    'heading_title' => 'Laravel',
    'title' => 'Login',
    'forgot_password_title' => 'Forgot Password',
    'reset_passowrd' => 'Reset Password',
    'change_password_title' => 'Change Password',
    'verify_otp_title' => 'OTP Verification',
    'label_email' => 'Email',
    'label_password' => 'Password',
    'label_verify_otp' => 'Enter OTP',
    'label_old_password' => 'Old Password',
    'label_new_password' => 'New Password',
    'label_confirm_password' => 'Confirm Password',
    'invalid_credentials_error' => 'Oops! You have entered invalid credentials',
    'invalid_email_error' => 'Invalid email entered.',
    'email_invalid_error' => 'Oops! We couldn\'t locate the email address in our records',
    'invalid_otp_error' => 'Invalid OTP. Please try again',
    'expired_otp_error' => 'OTP expired. Please try again',
    'recaptchaError' => 'reCAPTCHA verification failed. Please try again.',
    'ratelimit_forgot_password' => 'Please try again after 60 seconds.',
    'ratelimit_ip_restrication' => 'Your limit has been exceeded. Please try again tomorrow.',
    'ratelimit_email_restrication' => 'Your limit has been exceeded. Please try again tomorrow.',
    'label_back_to_login' => 'Back to Login',
    'invalid_new_password_error' => 'Password should contain at least one numeric character, one lowercase letter, one uppercase letter and one special character.',
    'wrong_password' => 'The password you entered is incorrect. Please try again.',
  ],
  'import_history' => 
  [
    'breadcrumb' => 
    [
      'title' => 'Import History',
      'list' => 'List',
      'role' => 'Role',
      'user' => 'User',
      'brand' => 'Brand',
    ],
    'messages' => 
    [
      'success' => 'Import is in progress, please keep paitence you will shortly recieve an email regarding the same',
      'validate_error' => 'At least one file must be selected',
    ],
  ],
  'dashboard' => 
  [
    'breadcrumb' => 
    [
      'title' => 'Quick Links',
      'sub_title' => 'Home',
      'list' => 'List',
    ],
  ],
  'permission' => 
  [
    'breadcrumb' => 
    [
      'title' => 'Permission Management',
      'sub_title' => 'Permission',
      'edit' => 'Assign Permission',
    ],
    'edit' => 
    [
      'label_role' => 'Role',
      'placeholder_role' => 'Select Role',
    ],
  ],
  'submit_button_text' => 'Submit',
  'reset_password_button_text' => 'Reset Password',
  'back_button_text' => 'Back',
  'go_to_button_text' => 'Go to listing',
  'confirm_button_text' => 'Confirm',
  'skip_button_text' => 'Skip',
  'skip_next_button_text' => 'Skip & Next',
  'skip_continue_button_text' => 'Finish',
  'update_button_text' => 'Update',
  'next_button_text' => 'Next',
  'cancel_button_text' => 'Cancel',
  'no_button_text' => 'No',
  'yes_button_text' => 'Yes',
  'edit_button_text' => 'Edit',
  'authentication_error' => 'Authentication Error',
  'something_went_wrong' => 'Something Went Wrong! Please try again later',
  'refreshTable' => 'pg:eventRefresh-default',
  'import' => 
  [
    'file_lable' => 'File',
    'date_lable' => 'Date',
    'no_of_rows_lable' => 'No. Of Rows',
    'status_lable' => 'Status',
    'actions_lable' => 'Actions',
  ],
  'export' => 
  [
    'export_waiting_message' => 
    [
      0 => 'Your data is on its way! Hang tight!',
      1 => 'Don\'t worry, we\'re working on it! Your data is important to us.',
      2 => 'Your patience is appreciated! We\'re making progress.',
      3 => 'Processing your data... Thanks for waiting!',
      4 => 'Stay calm! We\'re processing your information.',
      5 => 'Just a little longer! Your data is in good hands.',
      6 => 'Almost there! Your information is being processed.',
      7 => 'Keep calm and carry on! Your data is being handled.',
      8 => 'We\'re on it! Your data will be ready soon.',
      9 => 'Hang in there! Your data is being processed with lightning speed!',
      10 => 'Your data is being processed with precision and care.',
      11 => 'Hang tight! Your export is in progress.',
      12 => 'We\'re crunching the numbers for you. Just a moment!',
      13 => 'Your export is on its way! Thank you for your patience.',
      14 => 'Sit back and relax while we handle your export.',
      15 => 'We\'re working hard to deliver your export. Thank you for waiting!',
      16 => 'Your export is in the queue. It won\'t be long now.',
      17 => 'We\'re making progress on your export. Thanks for your understanding!',
      18 => 'Your data is getting ready for export. It\'ll be worth the wait!',
      19 => 'Just a little longer! Your export is almost done.',
      20 => 'Your export is our top priority. Hang in there!',
      21 => 'We\'re on track to complete your export. Thanks for your patience.',
      22 => 'Your export is in good hands. Stay tuned!',
      23 => 'The gears are turning as we process your export.',
      24 => 'Your data is moving through the export pipeline. Almost there!',
      25 => 'We\'re pushing through to complete your export. Thank you for your patience.',
      26 => 'Your export is underway. We appreciate your patience.',
      27 => 'Your data is being transformed into a comprehensive export.',
      28 => 'Rest assured, your export is being handled with care.',
      29 => 'Your export is receiving our full attention. Just a little longer!',
      30 => 'Your export is being meticulously prepared. Hang tight!',
      31 => 'We\'re putting the final touches on your export. It won\'t be long now.',
      32 => 'Your data is being sorted and organized for export.',
      33 => 'We\'re on the final stretch! Your export is coming soon.',
      34 => 'Your export is in the works. Thank you for your patience!',
      35 => 'Your data is being formatted for export. We appreciate your patience.',
      36 => 'Hang in there! Your export is in progress.',
      37 => 'Your export is progressing smoothly. Thank you for waiting!',
      38 => 'The finishing touches are being applied to your export.',
      39 => 'Your data is being processed with care. Thank you for your patience.',
      40 => 'Your export is our top priority. Stay tuned!',
      41 => 'We\'re making steady progress on your export. Hang tight!',
      42 => 'Your export is moving forward. We appreciate your patience.',
      43 => 'Your data is in good hands. We\'re working on your export.',
      44 => 'Your export is being processed efficiently. Thank you for your patience.',
      45 => 'Rest assured, your export is in progress. Hang in there!',
      46 => 'Your data is undergoing final checks before export. Almost there!',
      47 => 'We\'re polishing up your export. Thank you for your patience!',
      48 => 'Your export is receiving our full attention. Stay tuned!',
      49 => 'We\'re putting the final pieces together for your export.',
      50 => 'Your export is being processed with precision and accuracy.',
      51 => 'Hang tight! Your export is nearing completion.',
      52 => 'Your data is being carefully prepared for export. Stay tuned!',
      53 => 'We\'re working diligently to complete your export. Thank you for waiting!',
      54 => 'Your export is being handled with care. Hang in there!',
      55 => 'Your data is being processed with efficiency and speed.',
      56 => 'We\'re making great progress on your export. Stay tuned!',
      57 => 'Your export is being fine-tuned for perfection. Almost there!',
      58 => 'Hang tight! Your export is in good hands.',
      59 => 'Your data is in the final stages of export. Thank you for your patience!',
    ],
  ],
  'dropzone' => 
  [
    'title' => 'Bulk Upload',
    'note' => 'Drop files here or click to upload.',
    'file_type_text' => 'Upload CSV file - (Max: 5 MB]',
    'feaure_image_type_text' => 'Upload Feature Image - (Max: 5 MB]',
    'upload_image_type_text' => 'Upload Images - (Max: 5 MB]',
    'upload_image_zip_type_text' => 'Upload Images Zip - (Max: 40 MB]',
    'upload_record_limit_text' => 'Note: File will process in next 15 minutes and Upload up to 10,000 records in csv. <a wire:click="downloadSampleCsv" href="javascript:void(0];">Download sample</a>',
    'sample_zip_text' => 'Note: File will process in next 15 minutes. <a wire:click="downloadSampleCsv" href="javascript:void(0];">Download sample</a>',
  ],
  'side_menus' => 
  [
    'dashboard' => 'Quick Links',
    'label_logout' => 'Sign Out',
    'label_change_password' => 'Change Password',
    'label_role' => 'Role Management',
    'label_permission' => 'Permission',
    'user_import' => 'Import History',
  ],
  'meta_titles' => 
  [
    'dashboard' => 'Quick Links',
    'login' => 'Login - Admin Panel',
    'forgot_passowrd' => 'Forgot Password - Admin Panel',
    'reset_passowrd' => 'Reset Password - Admin Panel',
    'change_passowrd' => 'Change Password - Admin Panel',
  ],
  'tooltip' => 
  [
    'view' => 'View',
    'click_delete' => 'Click here to delete',
    'click_edit' => 'Edit Details',
  ],
  'common_message' => 
  [
    'delete_confirm_button_text' => 'Yes, delete it!',
    'delete_cancel_button_text' => 'Cancel',
    'change_success' => 'Changed Successfully.',
    'email_template_update' => 'Email Template Updated Successfully.',
  ],
  'footer_text' => 'ETS - Admin Panel. All Rights Reserved.',
  'role' => 
  [
    'validation' => 
    [
      'messsage' => 
      [
        0 => 
        [
          'required' => 'The name field is required.',
          'max' => 'The name should be a maximum of 191 characters.',
        ],
        1 => 
        [
          'required' => 'The bg color field is required.',
          'max' => 'The bg color should be a maximum of 191 characters.',
        ],
        'name' => 
        [
          'required' => 'The name field is required.',
          'max' => 'The name should be a maximum of 191 characters.',
        ],
        'bg_color' => 
        [
          'required' => 'The bg color field is required.',
          'max' => 'The bg color should be a maximum of 191 characters.',
        ],
      ],
    ],
    'listing' => 
    [
      'name' => 'name',
      'bg_color' => 'bg color',
      'tableName' => 'roles',
      'id' => 'Role id',
      'actions' => 'Actions',
    ],
    'show' => 
    [
      'details' => 
      [
        'name' => 'name',
        'bg_color' => 'bg color',
      ],
      'label_role' => 'Role Details',
    ],
    'create' => 
    [
      'label_name' => 'Name',
      'label_bg_color' => 'Bg color',
    ],
    'breadcrumb' => 
    [
      'list' => 'List',
      'title' => 'Role Management',
      'edit' => 'Edit',
      'create' => 'Create',
      'role' => 'Role',
    ],
    'messages' => 
    [
      'success' => 'Role created successfully',
      'update' => 'Role updated successfully',
      'delete' => 'Role deleted successfully',
      'record_not_found' => 'Record not found',
      'no_record_selected' => 'Please select at least one record',
      'delete_confirmation_text' => 'Are you sure you want to delete this Role?',
      'bulk_delete_confirmation_text' => 'Are you sure you want to delete :count items?',
      'bulk_delete_success_text' => 'Selected users have been deleted successfully',
      'bulk_delete_fail_text' => 'An error occurred while deleting',
      'image_delete' => 'Image deleted successfully',
    ],
    'role_delete' => 
    [
      'remark' => 'Remark',
    ],
  ],
  'side_menu' => 
  [
    'role' => 'Role',
    'user' => 'User',
    'brand' => 'Brand',
  ],
  'meta_title' => 
  [
    'index_role' => 'Role - Admin Panel',
    'edit_role' => 'Edit Role - Admin Panel',
    'create_role' => 'Create Role - Admin Panel',
    'index_user' => 'User - Admin Panel',
    'edit_user' => 'Edit User - Admin Panel',
    'create_user' => 'Create User - Admin Panel',
    'index_brand' => 'Brand - Admin Panel',
    'edit_brand' => 'Edit Brand - Admin Panel',
    'create_brand' => 'Create Brand - Admin Panel',
  ],
  'user' => 
  [
    'validation' => 
    [
      'messsage' => 
      [
        0 => 
        [
          'required' => 'The name field is required.',
          'max' => 'The name should be a maximum of 100 characters.',
        ],
        1 => 
        [
          'required' => 'The email field is required.',
          'max' => 'The email should be a maximum of 200 characters.',
          'email' => 'The email must be a valid email address.',
        ],
        2 => 
        [
          'required' => 'The password field is required.',
          'min' => 'The password should be at least 6 characters.',
          'max' => 'The password should be a maximum of 191 characters.',
        ],
        3 => 
        [
          'required' => 'The role id field is required.',
        ],
        4 => 
        [
          'required' => 'The dob field is required.',
          'date_format' => 'The dob must match the date format.',
        ],
        5 => 
        [
          'required' => 'The country id field is required.',
        ],
        6 => 
        [
          'required' => 'The state id field is required.',
        ],
        7 => 
        [
          'required' => 'The city id field is required.',
        ],
        8 => 
        [
          'required' => 'The gender field is required.',
          'in' => 'The gender must be one of the allowed values.',
        ],
        9 => 
        [
          'required' => 'The status field is required.',
          'in' => 'The status must be one of the allowed values.',
        ],
        10 => 
        [
          'required' => 'The sort order field is required.',
          'max' => 'The sort order should be a maximum of 191 characters.',
        ],
        'name' => 
        [
          'required' => 'The name field is required.',
          'max' => 'The name should be a maximum of 100 characters.',
        ],
        'email' => 
        [
          'required' => 'The email field is required.',
          'max' => 'The email should be a maximum of 200 characters.',
          'email' => 'The email must be a valid email address.',
        ],
        'password' => 
        [
          'required' => 'The password field is required.',
          'min' => 'The password should be at least 6 characters.',
          'max' => 'The password should be a maximum of 191 characters.',
        ],
        'role_id' => 
        [
          'required' => 'The role id field is required.',
        ],
        'dob' => 
        [
          'required' => 'The dob field is required.',
          'date_format' => 'The dob must match the date format.',
        ],
        'profile_image' => 
        [
          'required' => 'The profile field is required.',
          'max' => 'The profile should be a maximum of 4096 characters.',
        ],
        'country_id' => 
        [
          'required' => 'The country id field is required.',
        ],
        'state_id' => 
        [
          'required' => 'The state id field is required.',
        ],
        'city_id' => 
        [
          'required' => 'The city id field is required.',
        ],
        'gender' => 
        [
          'required' => 'The gender field is required.',
          'in' => 'The gender must be one of the allowed values.',
        ],
        'status' => 
        [
          'required' => 'The status field is required.',
          'in' => 'The status must be one of the allowed values.',
        ],
        'sort_order' => 
        [
          'required' => 'The sort order field is required.',
          'max' => 'The sort order should be a maximum of 191 characters.',
        ],
      ],
    ],
    'listing' => 
    [
      'name' => 'name',
      'email' => 'email',
      'roles' => 'roles',
      'dob' => 'dob',
      'gender' => 'gender',
      'status' => 'status',
      'sort_order' => 'sort order',
      'tableName' => 'users',
      'id' => 'User id',
      'actions' => 'Actions',
    ],
    'show' => 
    [
      'details' => 
      [
        'name' => 'name',
        'email' => 'email',
        'role_name' => 'role name',
        'dob' => 'dob',
        'profile' => 'profile',
        'country_name' => 'country name',
        'state_name' => 'state name',
        'city_name' => 'city name',
        'gender' => 'gender',
        'status' => 'status',
        'sort_order' => 'sort order',
      ],
      'label_user' => 'User Details',
    ],
    'create' => 
    [
      'label_name' => 'Name',
      'label_email' => 'Email',
      'label_password' => 'Password',
      'label_roles' => 'Roles',
      'label_dob' => 'Dob',
      'label_profile' => 'Profile',
      'label_countries' => 'Countries',
      'label_states' => 'States',
      'label_cities' => 'Cities',
      'label_gender' => 'Gender',
      'label_status' => 'Status',
      'label_sort_order' => 'Sort order',
    ],
    'breadcrumb' => 
    [
      'list' => 'List',
      'title' => 'User Management',
      'edit' => 'Edit',
      'create' => 'Create',
      'user' => 'User',
    ],
    'messages' => 
    [
      'success' => 'User created successfully',
      'update' => 'User updated successfully',
      'delete' => 'User deleted successfully',
      'record_not_found' => 'Record not found',
      'no_record_selected' => 'Please select at least one record',
      'delete_confirmation_text' => 'Are you sure you want to delete this User?',
      'bulk_delete_confirmation_text' => 'Are you sure you want to delete :count items?',
      'bulk_delete_success_text' => 'Selected users have been deleted successfully',
      'bulk_delete_fail_text' => 'An error occurred while deleting',
      'image_delete' => 'Image deleted successfully',
    ],
    'user_delete' => 
    [
      'remark' => 'Remark',
    ],
  ],
  'brand' => 
  [
    'validation' => 
    [
      'messsage' => 
      [
        0 => 
        [
          'required' => 'The name field is required.',
          'max' => 'The name should be a maximum of 191 characters.',
        ],
        2 => 
        [
          'required' => 'The status field is required.',
          'in' => 'The status must be one of the allowed values.',
        ],
        'name' => 
        [
          'required' => 'The name field is required.',
          'max' => 'The name should be a maximum of 191 characters.',
        ],
        'status' => 
        [
          'required' => 'The status field is required.',
          'in' => 'The status must be one of the allowed values.',
        ],
      ],
    ],
    'listing' => 
    [
      'name' => 'name',
      'remark' => 'remark',
      'status' => 'status',
      'tableName' => 'brands',
      'id' => 'Brand id',
      'actions' => 'Actions',
    ],
    'show' => 
    [
      'details' => 
      [
        'name' => 'name',
        'remark' => 'remark',
        'status' => 'status',
      ],
      'label_brand' => 'Brand Details',
    ],
    'create' => 
    [
      'label_name' => 'Name',
      'label_remark' => 'Remark',
      'label_status' => 'Status',
      'label_description' => 'Description',
      'label_brand_image' => 'Brand image',
      'label_bg_color' => 'Bg color',
    ],
    'breadcrumb' => 
    [
      'list' => 'List',
      'title' => 'Brand Management',
      'edit' => 'Edit',
      'create' => 'Create',
      'brand' => 'Brand',
    ],
    'messages' => 
    [
      'success' => 'Brand created successfully',
      'update' => 'Brand updated successfully',
      'delete' => 'Brand deleted successfully',
      'record_not_found' => 'Record not found',
      'no_record_selected' => 'Please select at least one record',
      'delete_confirmation_text' => 'Are you sure you want to delete this Brand?',
      'bulk_delete_confirmation_text' => 'Are you sure you want to delete :count items?',
      'bulk_delete_success_text' => 'Selected users have been deleted successfully',
      'bulk_delete_fail_text' => 'An error occurred while deleting',
      'image_delete' => 'Image deleted successfully',
    ],
    'brand_delete' => 
    [
      'remark' => 'Remark',
    ],
  ],
];
