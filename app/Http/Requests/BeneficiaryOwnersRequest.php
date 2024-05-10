<?php

namespace App\Http\Requests;

use App\Rules\BoPassportRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BeneficiaryOwnersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // // ===================================== FIRST APPLICANT INFORMATION =====================
            // // 'broker_id'                     => ['required',],
            // 'bo_category_id'                => ['required',],
            // 'bo_type_id'                    => ['required',],
            // 'name'                          => ['required',],
            // 'father_name'                   => ['required',],

            // 'date_of_birth'                 => ['required','date',],
            // 'gender'                        => ['required',],
            // 'mobile'                        => ['required','digits:11','numeric',],
            // // 'bo_id'                         => ['required','numeric',],
            // // 'telephone'                  => ['required',],
            // 'email'                         => ['required','email'],

            // 'nid'                           => ['required','numeric',],
            // 'occupation'                    => ['required',],
            // 'is_joint_account'              => ['required',],
            // 'is_authorized'                 => ['required',],
            // 'is_dealer'                     => ['required',],
            // // 'is_margin'                     => ['required',],
            // // 'margin_value'                  => ['required',],
            // 'present_address'               => ['required',],
            // 'present_country'               => ['required',],
            // 'present_division'              => ['required',],
            // 'present_city'                  => ['required',],
            // 'present_postcode'              => ['required','numeric',],
            // 'permanent_address'             => ['required',],
            // 'permanent_country'             => ['required',],
            // 'permanent_division'            => ['required',],
            // 'permanent_city'                => ['required',],
            // 'permanent_postcode'            => ['required','numeric',],

            // // 'passport_no'                   => ['required',],
            // // 'passport_issue_place'          => ['required',],
            // // 'passport_issue_date'           => ['required',],
            // // 'passport_expiry_date'          => ['required',],

            // 'passport_no' => [new BoPassportRule],
            // 'passport_issue_place' => [new BoPassportRule],
            // 'passport_issue_date' => [new BoPassportRule],
            // 'passport_expiry_date' => [new BoPassportRule],


            // // 'date_of_registration'          => ['required',],
            // 'residency_status'              => ['required',],
            // // 'country_id'                    => ['required',],

            // // 'is_active'                     => ['required',],
            // // 'charges_id'                     => ['required',],
            // //  ===================================== BANK DETAILS  =====================
            // 'bank_name'                     => ['required',],
            // 'branch_name'                   => ['required',],
            // 'account_no'                    => ['required','numeric',],
            // 'routing_no'                    => ['required','numeric',],
            // 'is_electronic_divident_credit' => ['required',],
            // 'is_tax_exemption'              => ['required',],
            // //   ===================================== Joint Account DETAILS =====================
            // // 'joint_person_name'             => ['required',],
            // // 'joint_person_father_name'      => ['required',],
            // // 'joint_person_mother_name'      => ['required',],
            // // 'joint_person_spouse_name'      => ['required',],
            // // 'joint_person_birth'            => ['required',],
            // // 'joint_person_gender'           => ['required',],
            // // 'joint_person_present_country'  => ['required',],
            // // 'joint_person_present_address'  => ['required',],
            // // 'joint_person_permanent_address'=> ['required',],
            // // 'joint_person_mobile'           => ['required',],
            // // 'joint_person_telephone'        => ['required',],
            // // 'joint_person_email'            => ['required','email'],
            // // 'joint_person_tin'              => ['required',],
            // // 'joint_person_nid'              => ['required',],
            // // 'joint_person_occupation'       => ['required',],

            // // ===================================== NOMINEE =====================
            // 'nominee_name'                      => ['required',],
            // 'relationship_id'                   => ['required',],
            // 'nominee_father_name'               => ['required',],
            // // 'percentage'                        => ['required',],
            // 'percentage.*'                        => ['required', 'numeric', 'between:0,99.99'],
            // 'nominee_date_of_birth'             => ['required',],
            // 'nominee_gender'                    => ['required',],
            // 'nominee_country_id'                => ['required',],
            // 'nominee_present_address'           => ['required',],
            // 'nominee_permanent_address'         => ['required',],
            // 'nominee_mobile'                    => ['required','numeric',],
            // // 'nominee_telephone'                 => ['required',],
            // 'nominee_telephone'                 => ['max:15'],
            // // 'nominee_email'                     => ['email',],
            // 'nominee_nid'                       => ['required','numeric',],
            // 'nominee_occupation'                => ['required',],
            // 'nominee_residency'                 => ['required',],


            // FIRST APPLICANT INFORMATION
            'bo_category_id' => 'required',
            'bo_type_id' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'father_name' => 'required',
            'mobile' => 'required|numeric',
            'email' => 'required|email',
            'nid' => 'required|numeric',
            'date_of_birth' => 'required|date',
            'occupation' => 'required',
            'is_joint_account' => 'required',
            'is_dealer' => 'required',
            // 'is_margin' => 'required',
            'is_account_link_request' => 'required',

            // PRESENT ADDRESS DETAILS
            'present_address' => 'required',
            'present_country' => 'required',
            'present_city' => 'required',
            'present_postcode' => 'required|numeric',
            'present_division' => 'required',

            // PERMANENT ADDRESS DETAILS
            'permanent_address' => 'required',
            'permanent_country' => 'required',
            'permanent_city' => 'required',
            'permanent_postcode' => 'required|numeric',
            'permanent_division' => 'required',

            // BANK DETAILS
            'bank_name' => 'required',
            'branch_name' => 'required',
            'account_no' => 'required|numeric',
            'routing_no' => 'required|numeric',

            // NOMINEE
            'nominee_name.*' => 'required',
            'relationship_id.*' => 'required',
            'nominee_father_name.*' => 'required',
            'percentage.*' => 'required|numeric|between:0,100',
            'nominee_date_of_birth.*' => 'required',
            'nominee_gender.*' => 'required',
            'nominee_country_id.*' => 'required',
            'nominee_present_address.*' => 'required',
            'nominee_permanent_address.*' => 'required',
            'nominee_mobile.*' => 'required|numeric',
            // 'nominee_email.*' => 'required|email',
            'nominee_nid.*' => 'required|numeric',
            'nominee_occupation.*' => 'required',
            'nominee_residency.*' => 'required',
            'if_nominee_is_minor.*' => 'required',
            'nominee_guardian_full_name.*' => 'required',
            'nominee_guardian_name_short.*' => 'required',

        ];
    }
    public function messages()
    {
        return [
            // // ===================================== FIRST APPLICANT INFORMATION =====================
            // // 'broker_id.required'                => 'The broker Name field is required!',
            // 'bo_category_id.required'           => 'BO category is required!',
            // 'name.required'                     => 'Account holder name is required!',
            // 'gender.required'                   => 'Gender name is required!',
            // 'father_name.required'              => 'Father name is required!',


            // // 'bo_id.required'                    => 'The bo id field is required!',
            // // 'bo_id.numeric'                     => 'The bo id field is accept only numeric number',
            // 'mobile.required'                   => 'The mobile field is required!',
            // 'mobile.in:11'                      => 'The mobile field is accept only 11 digit!',
            // 'mobile.numeric'                    => 'The mobile field is accept only numeric number',

            // 'email.required'                    => 'The email address field is required!',
            // 'email.email'                       => 'Please enter valid email address!',

            // 'nid.required'                      => 'The NID number is required!',
            // 'nid.numeric'                    => 'NID is accept only numeric number',
            // // 'date_of_registration.required'     => 'Birth registration number is required!',
            // 'date_of_birth.required'            => 'Date of birth is required!',
            // 'occupation.required'               => 'Occupation is required!',
            // 'is_joint_account.required'         => 'Is it joint account is required!',
            // 'is_dealer.required'                => 'Is dealer is required!',
            // // 'is_margin.required'                => 'Is margin is required!',
            // // 'margin_value.required'             => 'Is margin Value is required!',
            // 'is_account_link_request.required'  => 'Is account link request is required!',
            // 'residency_status.required'         => 'Residency status is required!',
            // // 'nationality.required'              => 'Nationality is required!',

            // 'present_address.required'          => 'Present address is required!',
            // 'present_country.required'          => 'Present country is required!',
            // 'present_city.required'             => 'Present city is required!',
            // 'present_postcode.required'         => 'Present postcode is required!',
            // 'present_division.required'         => 'Present division is required!',
            // 'permanent_address.required'        => 'Permanent address is required!',
            // 'permanent_country.required'        => 'Permanent country is required!',
            // 'permanent_city.required'           => 'Permanent city is required!',
            // 'permanent_postcode.required'       => 'Permanent postcode is required!',
            // 'permanent_division.required'       => 'Permanent division is required!',
            // // 'charges_id.required'               => 'Charges Title is required!',
            // //  ===================================== BANK DETAILS  =====================
            // 'bank_name.required'                         =>"Bank name is required",
            // 'branch_name.required'                       => "Bank branch is required",
            // 'account_no.required'                        => "Bank account number is required",
            // 'routing_no.required'                        => "Bank routing number is required",
            // 'is_electronic_divident_credit.required'     => "Is electronic divident credit is required",
            // 'is_tax_exemption.required'                  => "Is tax exemption is required",
            // // ===================================== PASSPORT DETAILS  =====================
            // 'passport_no.required'                     => "Passport no is required",
            // 'passport_issue_place.required'            => "Passport issue place is required",
            // 'passport_issue_date.required'             => "Passport issue date is required",
            // 'passport_expiry_date.required'            => "Passport expiry date is required",
            // //   ===================================== Joint Account DEATILS =====================
            // 'joint_person_name.required_if'             => "Joint person name is required",
            // 'joint_person_father_name.required_if'      => "Joint person father name is required",
            // 'joint_person_mother_name.required_if'      => "Joint person mother name is required",
            // 'joint_person_spouse_name.required_if'      => "Joint person spouse name is required",
            // 'joint_person_birth.required_if'            => "Joint person birth date is required",
            // 'joint_person_gender.required_if'           =>"Joint person gender is required",
            // 'joint_person_present_country.required_if'  => "Joint person present country is required",
            // 'joint_person_present_address.required_if'  => "Joint person present address is required",
            // 'joint_person_permanent_address.required_if'=> "Joint person permanent address is required",
            // 'joint_person_mobile.required_if'           => "Joint person mobile address is required",
            // 'joint_person_telephone.required_if'        => "Joint person telephone number is required",
            // 'joint_person_email.required_if'            => "Joint person email address is required",
            // 'joint_person_tin.required_if'              =>"Joint person E-Tin number is required",
            // 'joint_person_nid.required_if'              => "Joint person nid number is required",
            // 'joint_person_occupation.required_if'       => "Joint person occupation is required",
            // // ===================================== AUTHORIZED PERSON INFORMATION (OPTIONAL) =====================
            // 'authorized_person_name.required'             => "Authorized person name is required",
            // 'authorized_person_father_name.required'      => "Authorized person father name is required",
            // 'authorized_person_mother_name.required'      =>"Authorized person mother name is required",
            // 'authorized_person_spouse_name.required'      =>"Authorized person spouse name is required",
            // 'authorized_person_birth.required'            => "Authorized person birth date is required",
            // 'authorized_person_present_country.required'  => "Authorized person present country is required",
            // 'authorized_person_present_address.required'  => "Authorized person present address is required",
            // 'authorized_person_mobile.required'           => "Authorized person mobile number is required",
            // 'authorized_person_telephone.required'        => "Authorized person telephone number is required",
            // 'authorized_person_email.required'            => "Authorized person email address is required",
            // 'authorized_person_tin.required'              => "Authorized person  E-Tin number is required",
            // 'authorized_person_nid.required'              => "Authorized person nid number is required",
            // 'authorized_person_occupation.required'       => "Authorized person occupation is required",
            // 'authorized_person_nationality.required'      => "Authorized person nationality is required",
            // 'authorized_person_residency.required'        => "Authorized person residency is required",
            // 'is_exchange_listed_company.required'         => "Authorized person is exchange listed company is required",
            // 'stock_exchange_name.required'                => "Authorized person stock exchange name is required",
            // 'authorization_type.required'                 => "Authorized person authorization type is required",
            // // ===================================== NOMINEE =====================
            // 'nominee_name.required'                      => "Nominee name is required",
            // 'relationship_id.required'                   => "Nominee relation is required",
            // 'nominee_father_name.required'               => "Nominee father is required",
            // 'percentage.required' => "Nominee percentage is required",
            // 'percentage.numeric' => "Nominee percentage should be a numeric value",
            // 'percentage.between' => "Nominee percentage should be between 0 and 99.99",
            // 'nominee_date_of_birth.required'             => "Nominee date of birth is required",
            // 'nominee_gender.required'                    =>"Nominee gender is required",
            // 'nominee_country_id.required'                => "Nominee country name is required",
            // 'nominee_present_address.required'           => "Nominee present address is required",
            // 'nominee_permanent_address.required'         => "Nominee permanent address name is required",
            // 'nominee_mobile.required'                    => "Nominee mobile number is required",
            // // 'nominee_telephone.required'                 => "Nominee telephone number is required",
            // // 'nominee_email.required'                     => "Nominee email address is required",
            // 'nominee_nid.required'                       => "Nominee nid is required",
            // 'nominee_occupation.required'                => "Nominee occupation is required",
            // 'nominee_residency.required'                 => "Nominee residency is required",


            // FIRST APPLICANT INFORMATION
            'bo_category_id.required' => 'BO category field is required',
            'bo_type_id.required' => 'BO type field is required',
            'name.required' => 'Account holder name field is required',
            'gender.required' => 'Gender field is required',
            'father_name.required' => 'Father name field is required',
            'mobile.required' => 'Mobile number field is required',
            'mobile.numeric' => 'Mobile number should be a valid number',
            'email.required' => 'Email address field is required',
            'email.email' => 'Please enter a valid email address',
            'nid.required' => 'NID number field is required',
            'nid.numeric' => 'NID should be a valid number',
            'date_of_birth.required' => 'Date of birth field is required',
            'date_of_birth.date' => 'Please enter a valid date of birth',
            'occupation.required' => 'Occupation field is required',
            'is_joint_account.required' => 'Joint account field is required',
            'is_dealer.required' => 'Is dealer field is required',
            'is_margin.required' => 'Is margin field is required',
            'is_account_link_request.required' => 'Account link request field is required',

            // PRESENT ADDRESS DETAILS
            'present_address.required' => 'Present address field is required',
            'present_country.required' => 'Present country field is required',
            'present_city.required' => 'Present city field is required',
            'present_postcode.required' => 'Present post code field is required',
            'present_postcode.numeric' => 'Present post code should be a valid number',
            'present_division.required' => 'Present division field is required',

            // PERMANENT ADDRESS DETAILS
            'permanent_address.required' => 'Permanent address field is required',
            'permanent_country.required' => 'Permanent country field is required',
            'permanent_city.required' => 'Permanent city field is required',
            'permanent_postcode.required' => 'Permanent post code field is required',
            'permanent_postcode.numeric' => 'Permanent post code should be a valid number',
            'permanent_division.required' => 'Permanent division field is required',

            // BANK DETAILS
            'bank_name.required' => 'Bank name field is required',
            'branch_name.required' => 'Branch name field is required',
            'account_no.required' => 'Account no field is required',
            'account_no.numeric' => 'Account no should be a valid number',
            'routing_no.required' => 'Routing no field is required',
            'routing_no.numeric' => 'Routing no should be a valid number',

            // NOMINEE
            'nominee_name.*.required' => 'Nominee name field is required',
            'relationship_id.*.required' => 'Nominee relationship field is required',
            'nominee_father_name.*.required' => 'Nominee father name field is required',
            'percentage.*.required' => 'Nominee percentage field is required',
            'percentage.*.numeric' => 'Nominee percentage must be a valid number',
            'percentage.*.between' => 'Nominee percentage must be between 0 and 100',
            'nominee_date_of_birth.*.required' => 'Nominee date of birth field is required',
            'nominee_gender.*.required' => 'Nominee gender field is required',
            'nominee_country_id.*.required' => 'Nominee country field is required',
            'nominee_present_address.*.required' => 'Nominee present address field is required',
            'nominee_permanent_address.*.required' => 'Nominee permanent address field is required',
            'nominee_mobile.*.required' => 'Nominee mobile number field is required',
            'nominee_mobile.*.numeric' => 'Nominee mobile number should be a valid number',
            'nominee_email.*.required' => 'Nominee email address field is required',
            'nominee_email.*.email' => 'Please enter a valid email address',
            'nominee_nid.*.required' => 'Nominee NID field is required',
            'nominee_nid.*.numeric' => 'Nominee NID should be a valid number',
            'nominee_occupation.*.required' => 'Nominee occupation field is required',
            'nominee_residency.*.required' => 'Nominee residency field is required',
            'if_nominee_is_minor.*.required' => 'If nominee is a minor, this field is required',
            'nominee_guardian_full_name.*.required' => 'Nominee guardian full name field is required',
            'nominee_guardian_name_short.*.required' => 'Nominee guardian short name field is required',


        ];
    }
}
