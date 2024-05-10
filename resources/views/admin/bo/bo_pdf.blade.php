<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BO Account Opening Form</title>
</head>
<style>
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        color: black;
    }

    .feature {
        background: yellowgreen linear-gradient(to bottom, greenyellow, olivedrab);
        color: black;
    }

    #feature-carousel {
        min-height: 250px;
    }

    .article-intro {
        margin-bottom: 25px;
    }

    .footer-blurb {
        padding: 30px 0;
        background-color: yellowgreen;
        color: black;
    }

    .footer-blurb-item {
        padding: 30px;
    }

    .small-print {
        background-color: #fff;
        padding: 30px 0;
    }

    .feature,
    .page-intro,
    .article-intro,
    .footer-blurb,
    .small-print {
        text-align: center;
    }

    .dashobard-watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
        opacity: .1;
    }

    .company-logo {
        display: block;
        /* margin: auto; */
        margin-left: 220px;
        width: 250px;
    }

    .company-logo-middle {
        display: block;
        margin: auto;
        /* margin-left: 220px; */
        width: 250px;
    }

    .profile-photo {
        margin: auto;
        height: 200px;
        width: 150px;
        background-color: lightcyan;
    }

    .custom-account {
        text-align: center;
        background-color: #32c96b;
        padding: 6px;
    }

    .custom-account h4 {
        margin-bottom: 0px;
        /* color: white; */
        font-size: 16px;
    }

    .first-account-holder {
        margin: auto;
        background-color: rgb(240, 255, 255);
    }

    .first-account-holder .dotted-line {
        white-space: nowrap;
        position: relative;
        overflow: hidden;
        border-bottom: thin black dotted !important;
    }

    .from-input-wrap {
        width: 100%;
        height: auto;
        display: block;
    }

    .pdf-row {
        width: 100%;
        height: auto;
    }

    .pdf-col {
        width: auto;
        height: auto;
        margin: 2px 0px;
        display: inline-block;
        clear: both;
    }

    .pdf-col .label {
        width: auto;
        padding: 5px;
        display: inline-block;
    }

    .pdf-col .pdf-box {
        width: auto;
        padding: 5px;
        display: inline-block;
        border: 1px solid #ccc;
        min-width: 120px;
    }

    .right {
        float: right;
    }

    .fillup-wrap {
        width: 100%;
        height: auto;
        /* border: 1px solid #ccc; */
        display: block;
        /* background: #f1ecec59; */
        margin-bottom: 10px;
    }

    .pdf-box-border {
        display: inline-block;
        border-bottom: 2px dotted;
    }

    .fillup-wrap table {
        width: 100%;
    }

    .fillup-wrap table tr td:nth-child(2) {
        width: 40%;
    }

    .fillup-wrap table tr td:nth-child(1) {
        width: 32%;
    }

    .print-header {
        display: none;
    }

    .print-footer {
        display: none;
    }

    body {
        /* background: rgb(204,204,204); */
    }

    page {
        background: white;
        display: block;
        margin: 0 auto;
        margin-bottom: 0.5cm;
        box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        padding: 10px;
    }

    page[size="A4"] {
        width: 18cm;
        /* height: 29.7cm;  */
    }

    page[size="A4"][layout="portrait"] {
        width: 29.7cm;
        /* height: 21cm;   */
    }

    page[size="A3"] {
        width: 29.7cm;
        height: 42cm;
    }

    page[size="A3"][layout="portrait"] {
        width: 42cm;
        height: 29.7cm;
    }

    page[size="A5"] {
        width: 14.8cm;
        height: 21cm;
    }

    page[size="A5"][layout="portrait"] {
        width: 21cm;
        height: 14.8cm;
    }

    @media print {

        body,
        page {
            margin: 0;
            box-shadow: 0;
        }

        .print-header {
            display: block;
        }

        .print-footer {
            display: block;
        }
    }
</style>

<body>
    <header>
    </header>
    <main>
        <div class="container">
            <page size="A4">
                <section>
                    <div class="row">
                        <div class="dashobard-watermark" bis_skin_checked="1">
                            <div class="company-logo-middle">
                                {{-- <img style="width: 100%" src="{{ asset('/uploads/shebaGroupLogo.png') }}"
                                    alt="Header Avatar"> --}}
                                <img style="width: 100%"
                                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/uploads/shebaGroupLogo.png'))) }}"
                                    alt="Header Avatar">
                            </div>
                        </div>
                        <div class="col-lg-10">
                            {{-- <img class="company-logo" src='{{ asset('/uploads/ShebaCapital_Logo-01.png') }}'
                                alt="Logo"> --}}
                            <img class="company-logo"
                                src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/uploads/ShebaCapital_Logo-01.png'))) }}"
                                alt="Logo">
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center" style="text-align: center">
                            <p>House: 55, Road: 4/A Dhanmondi R/A, Dhaka, 1209</p>
                        </div>
                    </div>
                </section>
                <div class="pdf-row">
                    <h4 style="text-align: center;
                background: #32c96b;
                padding: 10px;">
                        CUSTOMER ACCOUNT INFORMATION FORM</h4>
                </div>

                <div class="from-heading"></div>
                <div class="from-input-wrap">
                    <div class="pdf-row">
                        <div class="pdf-col">
                            <div class="label">Date : </div>
                            <div class="pdf-box">&nbsp;</div>
                        </div>
                        <div class="pdf-col right">
                            <div class="label">Account Type : </div>
                            {{-- <div class="pdf-box">&nbsp;</div> --}}
                            <div class="label">
                                <label for="cash" style="margin-right: 10px;">
                                    <input type="checkbox" id="cash" name="Cash" value="cash"
                                        style="margin-right: 5px;">
                                    Cash
                                </label>
                                <label for="margin">
                                    <input type="checkbox" id="margin" name="margin" value="margin"
                                        style="margin-right: 5px;">
                                    Margin
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $beneficiaryOwners = $response['data']['beneficiaryOwners'];
                    $beneficiary_joint_holders = $response['data']['beneficiary_joint_holders'];
                    $beneficiary_authorizeds = $response['data']['beneficiary_authorizeds'];
                    $beneficiary_owners_banks = $response['data']['beneficiary_owners_banks'];
                    $gender = 2;
                    //echo '<pre>';print_r($beneficiaryOwners);echo '</pre>';exit;
                @endphp
                @if ($response['status'] === 'success')
                    <div class="from-input-wrap" style="width:680px">
                        <div class="pdf-row" style="margin-bottom: 10px; width:680px">
                            <div class="pdf-col">
                                <div class="label">Client Code : </div>
                                <div class="pdf-box">&nbsp;</div>
                            </div>
                            <div class="pdf-col right">
                                <div class="label">Link Code : </div>
                                <div class="pdf-box">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                    <div class="from-input-wrap">
                        <div class="fillup-wrap">
                            <div style="font-weight: bold; padding: 5px">First Account Holder</div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Name of the Customer : </div>
                                    <div class="pdf-box-border" style="width: 300px;">{{ $beneficiaryOwners->name }}
                                    </div>
                                </div>
                                <div class="pdf-col right">
                                    <div class="label">Registration Id : </div>
                                    <div class="pdf-box-border" style="width: 80px;">SCL-{{ $beneficiaryOwners->id }}
                                    </div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Father's/Husband's Name : </div>
                                    <div class="pdf-box-border" style="width:466px">
                                        {{ $beneficiaryOwners->father_name }}</div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Mother's Name : </div>
                                    <div class="pdf-box-border" style="width: 530px;">
                                        {{ $beneficiaryOwners->mother_name }}</div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Date of Birth : </div>
                                    <div class="pdf-box-border" style="width: 395px;">
                                        {{ $beneficiaryOwners->date_of_birth }}</div>
                                    <div class="label">
                                        Sex:
                                        <label for="male" style="margin-right: 10px;">
                                            <input type="checkbox" id="male" name="sex" value="male"
                                                {{ $beneficiaryOwners->gender == 1 ? 'checked' : '' }}
                                                style="margin-right: 5px;">
                                            Male
                                        </label>
                                        <label for="female">
                                            <input type="checkbox" id="female" name="sex" value="female"
                                                {{ $beneficiaryOwners->gender == 2 ? 'checked' : '' }}
                                                style="margin-right: 5px;">
                                            Female
                                        </label>
                                        <label for="common">
                                            <input type="checkbox" id="common" name="sex" value="common"
                                                {{ $beneficiaryOwners->gender == 3 ? 'checked' : '' }}
                                                style="margin-right: 5px;">
                                            Common
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Present Address : </div>
                                    <div class="pdf-box-border" style="width: 530px">
                                        {{ $beneficiaryOwners->present_address }}</div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Mobile : </div>
                                    <div class="pdf-box-border" style="width: 315px;">
                                        {{ $beneficiaryOwners->mobile }}</div>
                                    <div class="label">Tel : </div>
                                    <div class="pdf-box-border" style="width: 227px;">&nbsp;</div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Permanent Address : </div>
                                    <div class="pdf-box-border" style="width: 509px;">
                                        {{ $beneficiaryOwners->permanent_address }}</div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">E-mail ID : </div>
                                    <div class="pdf-box-border" style="width: 300px;">{{ $beneficiaryOwners->email }}
                                    </div>
                                    <div class="label">Occupation : </div>
                                    <div class="pdf-box-border" style="width: 168px;">
                                        {{ $beneficiaryOwners->occupation }}</div>
                                    <div class="pdf-box-border" style="width: 277px;">
                                        {{ $beneficiaryOwners->occupation_title }}</div>
                                </div>
                            </div>

                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Nationality :</div>
                                    <div class="pdf-box-border" style="width: 300px;">&nbsp;</div>
                                    <div class="label">E-Tin : </div>
                                    <div class="pdf-box-border" style="width: 196px;">{{ $beneficiaryOwners->e_tin }}
                                    </div>
                                </div>
                            </div>

                        </div>
                        @foreach ($beneficiary_joint_holders as $beneficiary_joint_holder)
                            <div class="fillup-wrap">
                                <div style="font-weight: bold; padding: 5px">Joint Account Holder</div>
                                <div class="pdf-row">
                                    <div class="pdf-col">
                                        <div class="label">Name of Joint Account Holder : </div>
                                        <div class="pdf-box-border" style="width: 460px;">
                                            {{ $beneficiary_joint_holder->name }}</div>
                                    </div>
                                </div>
                                <div class="pdf-row">
                                    <div class="pdf-col">
                                        <div class="label">Father's/Husband's Name : </div>
                                        <div class="pdf-box-border" style="width:478px">
                                            {{ $beneficiary_joint_holder->fathers_name }}</div>
                                    </div>
                                </div>
                                <div class="pdf-row">
                                    <div class="pdf-col">
                                        <div class="label">Mother's Name : </div>
                                        <div class="pdf-box-border" style="width: 542px;">
                                            {{ $beneficiary_joint_holder->mothers_name }}</div>
                                    </div>
                                </div>
                                <div class="pdf-row">
                                    <div class="pdf-col">
                                        <div class="label">Date of Birth : </div>
                                        <div class="pdf-box-border" style="width: 395px;">
                                            {{ $beneficiary_joint_holder->date_of_birth }}</div>
                                        <div class="label">
                                            Sex:
                                            <label for="male" style="margin-right: 10px;">
                                                <input type="checkbox" id="male" name="sex" value="male"
                                                    {{ $beneficiary_joint_holder->gender == 1 ? 'checked' : '' }}
                                                    style="margin-right: 5px;">
                                                Male
                                            </label>
                                            <label for="female">
                                                <input type="checkbox" id="female" name="sex" value="female"
                                                    {{ $beneficiary_joint_holder->gender == 2 ? 'checked' : '' }}
                                                    style="margin-right: 5px;">
                                                Female
                                            </label>
                                            <label for="common">
                                                <input type="checkbox" id="common" name="sex" value="common"
                                                    {{ $beneficiary_joint_holder->gender == 3 ? 'checked' : '' }}
                                                    style="margin-right: 5px;">
                                                Common
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="pdf-row">
                                    <div class="pdf-col">
                                        <div class="label">Present Address : </div>
                                        <div class="pdf-box-border" style="width: 542px">
                                            {{ $beneficiary_joint_holder->present_address }}</div>
                                    </div>
                                </div>
                                <div class="pdf-row">
                                    <div class="pdf-col">
                                        <div class="label">Mobile : </div>
                                        <div class="pdf-box-border" style="width: 315px;">
                                            {{ $beneficiary_joint_holder->mobile }}</div>
                                        <div class="label">Tel : </div>
                                        <div class="pdf-box-border" style="width: 237px;">
                                            {{ $beneficiary_joint_holder->telephone }}</div>
                                    </div>
                                </div>
                                <div class="pdf-row">
                                    <div class="pdf-col">
                                        <div class="label">Permanent Address : </div>
                                        <div class="pdf-box-border" style="width: 522px;">
                                            {{ $beneficiary_joint_holder->permanent_address }}</div>
                                    </div>
                                </div>
                                <div class="pdf-row">
                                    <div class="pdf-col">
                                        <div class="label">E-mail ID : </div>
                                        <div class="pdf-box-border" style="width: 300px;">
                                            {{ $beneficiary_joint_holder->email }}</div>
                                        <div class="label">Occupation : </div>
                                        <div class="pdf-box-border" style="width: 180px;">
                                            {{ $beneficiary_joint_holder->occupation }}</div>
                                        <div class="pdf-box-border" style="width: 277px;">
                                            {{ $beneficiary_joint_holder->occupation_title }}</div>
                                    </div>
                                </div>

                                <div class="pdf-row">
                                    <div class="pdf-col">
                                        <div class="label">Nationality :</div>
                                        <div class="pdf-box-border" style="width: 300px;">&nbsp;</div>
                                        <div class="label">E-Tin # : </div>
                                        <div class="pdf-box-border" style="width: 213px;">
                                            {{ $beneficiary_joint_holder->e_tin }}</div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                        <footer class="print-footer">
                            <div class="pdf-row">
                                <p style="text-align: center">Room # 602, Stock Exchange Building, 9/F, Motijheel C/A,
                                    Dhaka- 1000, Bangladesh</p>
                                <p style="text-align: center">Phone # 01818404590, Website :
                                    www.shebacapital.com,Email: shebacapital@gmail.com </p>
                            </div>
                        </footer>

                        <section class="print-header">
                            <div class="row">
                                <div class="dashobard-watermark" bis_skin_checked="1">
                                    <img class="company-logo" src="{{ asset('/uploads/shebaGroupLogo.png') }}"
                                        alt="Header Avatar">

                                </div>
                                <div class="col-lg-10">
                                    <img class="company-logo" src="{{ asset('/uploads/ShebaCapital_Logo-01.png') }}"
                                        alt="Logo">
                                </div>
                            </div>
                            <div class="row">
                                <div class="text-center" style="text-align: center">
                                    <p>House: 55, Road: 4/A Dhanmondi R/A, Dhaka, 1209</p>
                                </div>
                            </div>
                        </section>
                        <div class="fillup-wrap">
                            <div style="font-weight: bold; padding: 5px">Authorized Person Information</div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Name of Authorized Person : </div>
                                    <div class="pdf-box-border" style="width: 470px;">
                                        {{ $beneficiary_authorizeds->name }}</div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Father's/Husband's Name : </div>
                                    <div class="pdf-box-border" style="width:486px">
                                        {{ $beneficiary_authorizeds->fathers_name }}</div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Mother's Name : </div>
                                    <div class="pdf-box-border" style="width: 550px;">
                                        {{ $beneficiary_authorizeds->mothers_name }}</div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Date of Birth : </div>
                                    <div class="pdf-box-border" style="width: 395px;">
                                        {{ $beneficiary_authorizeds->date_of_birth }}</div>
                                    <div class="label">
                                        Sex:
                                        <label for="male" style="margin-right: 10px;">
                                            <input type="checkbox" id="male" name="sex" value="male"
                                                {{ $beneficiary_authorizeds->gender == 1 ? 'checked' : '' }}
                                                style="margin-right: 5px;">
                                            Male
                                        </label>
                                        <label for="female">
                                            <input type="checkbox" id="female" name="sex" value="female"
                                                {{ $beneficiary_authorizeds->gender == 2 ? 'checked' : '' }}
                                                style="margin-right: 5px;">
                                            Female
                                        </label>
                                        <label for="common">
                                            <input type="checkbox" id="common" name="sex" value="common"
                                                {{ $beneficiary_authorizeds->gender == 3 ? 'checked' : '' }}
                                                style="margin-right: 5px;">
                                            Common
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Present Address : </div>
                                    <div class="pdf-box-border" style="width: 540px">
                                        {{ $beneficiary_authorizeds->present_address }}</div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Mobile : </div>
                                    <div class="pdf-box-border" style="width: 315px;">
                                        {{ $beneficiary_authorizeds->mobile }}</div>
                                    <div class="label">Tel : </div>
                                    <div class="pdf-box-border" style="width: 240px;">
                                        {{ $beneficiary_authorizeds->telephone }}</div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Permanent Address : </div>
                                    <div class="pdf-box-border" style="width: 522px;">
                                        {{ $beneficiary_authorizeds->permanent_address }}</div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">E-mail ID : </div>
                                    <div class="pdf-box-border" style="width: 300px;">
                                        {{ $beneficiary_authorizeds->email }}</div>
                                    <div class="label">Occupation : </div>
                                    <div class="pdf-box-border" style="width: 180px;">
                                        {{ $beneficiary_authorizeds->occupation }}</div>
                                    <div class="pdf-box-border" style="width: 275px;">
                                        {{ $beneficiary_authorizeds->occupation_title }}</div>
                                </div>
                            </div>

                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Nationality :</div>
                                    <div class="pdf-box-border" style="width: 300px;">&nbsp;</div>
                                    <div class="label">E-Tin : </div>
                                    <div class="pdf-box-border" style="width: 210px;">
                                        {{ $beneficiary_authorizeds->e_tin }}</div>
                                </div>
                            </div>

                        </div>
                        <div class="fillup-wrap">
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Officer or Director or Spnosor Shareholder of any Stock
                                        Exchange Listed Comp : </div>
                                    {{-- <div class="label">Yes     NO</div> --}}
                                    <div class="label">
                                        <label for="yes" style="margin-right: 10px;">
                                            <input type="checkbox" id="yes" name="yesNo" value="yes"
                                                style="margin-right: 5px;">
                                            Yes
                                        </label>
                                        <label for="no">
                                            <input type="checkbox" id="no" name="yesNo" value="no"
                                                style="margin-right: 5px;">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">If yes, Name of the Stock Exchange/Listed Company :</div>
                                    <div class="pdf-box-border" style="width: 300px;">&nbsp;</div>
                                    <div class="label">Signature : </div>
                                    <div class="pdf-box-border" style="width: 115px;">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                        <div class="fillup-wrap">
                            <div style="font-weight: bold; padding: 5px">Bank Information</div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Bank Name : </div>
                                    <div class="pdf-box-border" style="width: 578px;">
                                        {{ $beneficiary_owners_banks->bank_name }}</div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Branch Name : </div>
                                    <div class="pdf-box-border" style="width:565px">
                                        {{ $beneficiary_owners_banks->branch_name }}</div>
                                </div>
                            </div>
                            <div class="pdf-row">
                                <div class="pdf-col">
                                    <div class="label">Account No :</div>
                                    <div class="pdf-box-border" style="width:290px">
                                        {{ $beneficiary_owners_banks->account_no }}</div>
                                    <div class="label">Routing No : </div>
                                    <div class="pdf-box-border" style="width:185px">
                                        {{ $beneficiary_owners_banks->routing_no }}</div>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 5px"><strong>Declaration : </strong> It is hereby declared that all the
                            above mentioned information in customer account information form are true & valid.</div>
                        <div class="fillup-wrap">
                            <table style="border-collapse: collapse;">
                                <tr>
                                    <th style="border: 1px solid black; padding: 8px;">SL</th>
                                    <th style="border: 1px solid black; padding: 8px;">Name</th>
                                    <th style="border: 1px solid black; padding: 8px;">Signature with Date</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid black; padding: 8px;">First Account Holder</td>
                                    <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                                    <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid black; padding: 8px;">Second Account Holder</td>
                                    <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                                    <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid black; padding: 8px;">Officer/Manager/Branch In-charge
                                    </td>
                                    <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                                    <td style="border: 1px solid black; padding: 8px;">&nbsp;</td>
                                </tr>
                            </table>
                @endif
                <footer class="print-footer">
                    <div class="pdf-row">
                        <p style="text-align: center">Room # 602, Stock Exchange Building, 9/F, Motijheel C/A,
                            Dhaka- 1000, Bangladesh</p>
                        <p style="text-align: center">Phone # 01818404590, Website : www.shebacapital.com,Email:
                            shebacapital@gmail.com </p>
                    </div>
                </footer>
        </div>
        </div>
        </page>
        </div>
    </main>


    <footer>
    </footer>
</body>

</html>
