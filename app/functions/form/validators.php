<?php

// //////////////////////////////
// [1] FORM VALIDATORS
// //////////////////////////////

/**
 * Check if login is successful
 *
 * @param $form_values
 * @param array $form
 * @return bool
 */
function validate_login($form_values, array &$form): bool
{
    $fileDB = new FileDB(DB_FILE);
    $fileDB->load();

    if ($fileDB->getRowWhere('users', [
        'email' => $form_values['email'],
        'password' => $form_values['password']])) {
        return true;
    }


    $form['error'] = 'Unable to login: check your email and/or password';

    return false;
}

// //////////////////////////////
// [2] FIELD VALIDATORS
// //////////////////////////////

/**
 * Check if email is available for registration, i.e. if it is not already taken
 *
 * @param string $field_value
 * @param array $field
 * @return bool
 */
function validate_user_unique(string $field_value, array &$field): bool
{

    $fileDB = new FileDB(DB_FILE);
    $fileDB->load();
    $db_data = $fileDB->getData();

    foreach ($db_data['users'] as $entry) {
        if ($field_value === $entry['email']) {
            $field['error'] = 'Email is already taken: enter new email.';

            return false;
        }
    }

    return true;
}