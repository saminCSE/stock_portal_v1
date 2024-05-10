<?php

require 'vendor/autoload.php'; // Include Composer autoloader

use Goutte\Client;

// Your database connection parameters
$db_name = "sheba_trade_3";
$db_host = "localhost";
$db_username = "root";
$db_password = "";

// Create a new MySQLi connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

echo "Connection successful...!!!\n\n";

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// List of instrument codes
// $instrument_codes_list = ['GRAMEENS2', 'AAMRANET', 'DEBARACEM', 'RAHIMAFOOD', '1STPRIMFMF', 'SBACBANK', 'WALTONHIL'];
$instrument_codes_list = ['GRAMEENS2', 'AAMRANET', 'DEBARACEM'];

try {
    // Create a new Goutte client
    $client = new Client();

    // Loop through each instrument code
    foreach ($instrument_codes_list as $search_code) {
        // Create the URL with the current search code
        $url = "https://www.dsebd.org/displayCompany.php?name=" . urlencode($search_code);

        // Make a request to the URL
        $crawler = $client->request('GET', $url);

        // Check if the request was successful
        if ($client->getResponse()->getStatusCode() === 200) {
            // Find the table with the class 'shares-table'
            $table = $crawler->filter('table.shares-table')->first();

            if ($table->count() > 0) {
                // Table found, continue processing...
                echo "Table found for $search_code\n";

                // Find specific elements using CSS selectors
                $tradingCodeElement = $table->filter('th:contains("Trading Code:")')->first();
                $scripCodeElement = $table->filter('th:contains("Scrip Code:")')->first();

                if ($tradingCodeElement->count() > 0 && $scripCodeElement->count() > 0) {
                    // Extract the company code and DSE scrip code
                    $companyCode = trim(str_replace('Trading Code:', '', $tradingCodeElement->text()));
                    $dseScripCode = trim(str_replace('Scrip Code:', '', $scripCodeElement->text()));

                    echo "Company Code: $companyCode\n";
                    echo "DSE Scrip Code: $dseScripCode\n";

                    // Add a space before the company code for comparison
                    $companyCodeWithSpace = " " . $companyCode;
                    echo "Company Code with Space: $companyCodeWithSpace\n";

                    // Check if the company code with space matches the search code
                    if ($companyCodeWithSpace == " " . $search_code) {
                        echo "Company with code '$search_code' exists in DSE company-list.\n";

                        // Find the company name within the <i> tag
                        $h2Element = $crawler->filter('h2.BodyHead.topBodyHead')->first();

                        if ($h2Element->count() > 0) {
                            // Find the company name within the <i> tag
                            $companyNameElement = $h2Element->filter('i')->first();

                            if ($companyNameElement->count() > 0) {
                                $companyName = $companyNameElement->text();
                                echo "Company Name: $companyName\n";

                                // Find the specific cells using XPath
                                $dseListingYearCell = $crawler->filterXPath('//td[contains(text(), "Listing Year")]/following-sibling::td[1]')->first();
                                $marketCategoryCell = $crawler->filterXPath('//td[contains(text(), "Market Category")]/following-sibling::td[1]')->first();
                                $electronicShareCell = $crawler->filterXPath('//td[contains(text(), "Electronic Share")]/following-sibling::td[1]')->first();
                                $headOfficeCell = $crawler->filterXPath('//td[contains(text(), "Head Office")]/following-sibling::td[1]')->first();
                                $factoryCell = $crawler->filterXPath('//td[contains(text(), "Factory")]/following-sibling::td[1]')->first();
                                $contactPhoneCell = $crawler->filterXPath('//td[contains(text(), "Contact Phone")]/following-sibling::td[1]')->first();
                                $faxCell = $crawler->filterXPath('//td[contains(text(), "Fax")]/following-sibling::td[1]')->first();

                                $lastAgmElement = $crawler->filter('.col-sm-6.pull-left i')->first();
                                $divElements = $crawler->filter('div.col-sm-6.pull-right');

                                // $reserveCell = $crawler->filterXPath('//th[contains(text(), "Reserve & Surplus without OCI (mn)")]/following-sibling::td[1]')->first();
                                // $comprehensiveIncomeCell = $crawler->filterXPath('//th[contains(text(), "Other Comprehensive Income (OCI) (mn)")]/following-sibling::td[1]')->first();
                                $reserveCell = $crawler->filterXPath('//tr[@class="alt"]/th[contains(text(), "Reserve & Surplus without OCI (mn)")]/following-sibling::td[1]')->first();
                                $comprehensiveIncomeCell = $crawler->filterXPath('//tr/th[contains(a/@href, "comprehensive_income/Other-Comprehensive-Income.pdf")]/following-sibling::td[1]')->first();


                                // Find the last "Share Holding Percentage" section using CSS selector
                                $shareHoldingSection = $crawler->filterXPath('//tr[td[contains(text(), "Share Holding Percentage")]]')->last();

                                // Find all the percentage values within the section
                                $percentageCells = $shareHoldingSection->filter('td[width="27%"]');

                                // Extract the text content from the cells
                                $dseListingYear = $dseListingYearCell ? $dseListingYearCell->text() : '';
                                $marketCategory = $marketCategoryCell ? $marketCategoryCell->text() : '';
                                $electronicShare = $electronicShareCell ? $electronicShareCell->text() : '';

                                // Check if dseListingYear is not found, set it to None
                                if (!$dseListingYear || trim($dseListingYear) == '-' || !$dseListingYearCell) {
                                    $dseListingYear = 0;
                                }

                                $headOfficeAddress = $headOfficeCell ? $headOfficeCell->text() : '';
                                $factoryOfficeAddress = $factoryCell ? $factoryCell->text() : '';
                                $phone = $contactPhoneCell ? $contactPhoneCell->text() : '';
                                $fax = $faxCell ? $faxCell->text() : '';

                                // Initialize variables to store the extracted data (default to empty strings)
                                $lastAgmHeldOn = '';
                                $yearEnd = '';
                                $reserveSurplus = '';
                                $comprehensiveIncome = '';
                                $percentage = '';
                                $directorsProfileName = '';

                                // Use text() instead of textContent
                                if ($lastAgmElement) {
                                    $lastAgmHeldOn = $lastAgmElement->text();
                                    echo "AGM date in DSE: $lastAgmHeldOn\n";

                                    // Attempt to create a DateTime object from the string
                                    $dateObj = DateTime::createFromFormat('d-m-Y', $lastAgmHeldOn);

                                    // Check if the date creation was successful
                                    if ($dateObj !== false) {
                                        // Extract only the year from the DateTime object
                                        $lastAgmHeldOn = $dateObj->format('Y');
                                        echo "Database date format: $lastAgmHeldOn\n";
                                    } else {
                                        echo "Invalid date format: $lastAgmHeldOn\n";
                                        // $lastAgmHeldOn = 'N/A';
                                        $lastAgmHeldOn = null; // Set to null for database insertion
                                    }
                                }


                                // Check if the last AGM date is 'N/A' (case-insensitive)
                                if (strtolower($lastAgmHeldOn) == 'n/a' || !$lastAgmHeldOn || trim($lastAgmHeldOn) == '-') {
                                    echo "Last AGM date not available for company -> '$search_code'.\n";
                                    $lastAgmHeldOn = 'N/A';
                                } else {
                                    // Continue with the insertion/update process
                                    try {
                                        // Convert the date format to 'yyyy'
                                        try {
                                            $dateObj = DateTime::createFromFormat('d-m-Y', $lastAgmHeldOn);

                                            // Check if the date conversion was successful
                                            if ($dateObj !== false) {
                                                $lastAgmHeldOn = $dateObj->format('Y');
                                                echo "Database date format: $lastAgmHeldOn\n";

                                                // Continue with the rest of the insertion/update process...
                                                // (the existing code for insertion/update)
                                            } else {
                                                echo "Invalid date format: $lastAgmHeldOn\n";
                                                $lastAgmHeldOn = 'N/A';
                                            }
                                        } catch (Exception $ex) {
                                            echo "Error processing date: " . $ex->getMessage() . "\n";
                                            $lastAgmHeldOn = 'N/A';
                                        }
                                    } catch (PDOException $e) {
                                        echo "Error inserting data: " . $e->getMessage() . "\n";
                                    }
                                }

                                // Iterate through the div elements and check for the text
                                foreach ($divElements as $divElement) {
                                    // Use textContent instead of nodeValue
                                    $text = $divElement->textContent;
                                    if (strpos($text, "For the year ended:") !== false) {
                                        $yearEndText = str_replace("For the year ended:", "", trim($text));

                                        // Try to create a DateTime object with the assumed format 'd-m-Y'
                                        $dateObj = DateTime::createFromFormat('d-m-Y', $yearEndText);

                                        if ($dateObj !== false) {
                                            // Successfully created DateTime object
                                            $yearEnd = $dateObj->format('Y-m-d');
                                            echo "For the year ended Database date format: $yearEnd\n";
                                        } else {
                                            // Attempt to parse the date with the specific format 'M d, Y'
                                            preg_match('/([A-Za-z]+) (\d{1,2}), (\d{4})/', $yearEndText, $matches);

                                            if (count($matches) === 4) {
                                                // Successfully matched and extracted components
                                                $month = $matches[1];
                                                $day = $matches[2];
                                                $year = $matches[3];

                                                // Convert month name to numeric value
                                                $monthNum = date_parse($month)['month'];

                                                // Format the date as 'Y-m-d'
                                                $yearEnd = sprintf('%04d-%02d-%02d', $year, $monthNum, $day);
                                                echo "For the year ended Database date format: $yearEnd\n";
                                            } else {
                                                // Unable to parse the date with known formats, use original text
                                                echo "For the year ended Invalid date format: $yearEndText\n";
                                                $yearEnd = $yearEndText;
                                            }
                                        }

                                        break; // Stop searching after finding the desired text
                                    }
                                }

                                if ($reserveCell && count($reserveCell) > 0) {
                                    $reserveSurplus = str_replace(',', '', $reserveCell->text());
                                    echo "Reserve & Surplus without OCI: $reserveSurplus\n";
                                } else {
                                    echo "Error: The reserve node list is empty.\n";
                                }

                                if ($comprehensiveIncomeCell && count($comprehensiveIncomeCell) > 0) {
                                    $comprehensiveIncome = str_replace(',', '', $comprehensiveIncomeCell->text());
                                    echo "Other Comprehensive Income (OCI): $comprehensiveIncome\n";
                                } else {
                                    echo "Error: The comprehensive income node list is empty.\n";
                                }


                                // Print the extracted data
                                // echo "DSE Listing Year: $dseListingYear\n";
                                // echo "Market Category: $marketCategory\n";
                                // echo "Electronic Share: $electronicShare\n";

                                // echo "Head Office Address: $headOfficeAddress\n";
                                // echo "Factory Address: $factoryOfficeAddress\n";
                                // echo "Contact Phone: $phone\n";
                                // echo "Fax: $fax\n";

                                // echo "Last AGM held on: $lastAgmHeldOn\n";
                                // echo "For the year ended: $yearEnd\n";

                                echo "Reserve & Surplus without OCI (mn): $reserveSurplus\n";
                                echo "Other Comprehensive Income (OCI) (mn): $comprehensiveIncome\n";

                                // ...
                                try {
                                    // Check if the company exists in the database
                                    $checkQuery = "SELECT * FROM company_basic_information WHERE code = ?";
                                    $stmt = $conn->prepare($checkQuery);
                                    $stmt->bind_param("s", $search_code);
                                    $stmt->execute();

                                    $existingRecord = $stmt->get_result()->fetch_assoc();

                                    echo "Company code '$search_code' Selected.\n";

                                    // Step 1: Find the id from the instruments table based on the instrument code
                                    $findInstrumentIdQuery = "SELECT id FROM instruments WHERE instrument_code = ?";
                                    $stmt = $conn->prepare($findInstrumentIdQuery);
                                    $stmt->bind_param("s", $search_code);
                                    $stmt->execute();

                                    $instrumentResult = $stmt->get_result();

                                    // Check if a result is found
                                    if ($instrumentResult->num_rows > 0) {
                                        echo "Instrument update table\n";

                                        // Fetch the first row as an associative array
                                        $row = $instrumentResult->fetch_assoc();
                                        $instrumentId = $row['id'];

                                        echo "The id for instrument code '$search_code' is $instrumentId\n";

                                        // Step 2: Search for the selected id in company_agm_information and select company_id
                                        $selectCompanyIdQuery = "SELECT company_id FROM company_agm_information WHERE company_id = ?";
                                        $stmt = $conn->prepare($selectCompanyIdQuery);
                                        $stmt->bind_param("i", $instrumentId);
                                        $stmt->execute();

                                        $companyIdResult = $stmt->get_result();

                                        if ($companyIdResult->num_rows > 0) {
                                            // Fetch the first row as an associative array
                                            $row = $companyIdResult->fetch_assoc();
                                            $companyId = $row['company_id'];

                                            echo "Company ID for search code '$search_code' is $companyId\n";
                                            echo "AGM info already available. Update started for AGM...\n";

                                            $currentDatetime = date('Y-m-d H:i:s');

                                            // Check if last_agm_held_on is 'N/A'
                                            if (strtolower($lastAgmHeldOn) == 'n/a' || strtolower($lastAgmHeldOn) == '') {
                                                echo "Last AGM date not available for company -> '$search_code'. Updating AGM date to -> [NULL].\n";
                                                $lastAgmHeldOn = null;
                                            }

                                            // Create a dictionary of values for AGM information
                                            $updateData = [
                                                'company_id' => $companyId,
                                                'last_agm_held_on' => $lastAgmHeldOn,
                                                'year_end' => $yearEnd,
                                                'reserve_surplus' => $reserveSurplus,
                                                'comprehensive_income' => $comprehensiveIncome,
                                                'updated_by' => 1,
                                                'updated_at' => $currentDatetime
                                            ];

                                            // SQL UPDATE query for AGM information
                                            $updateQuery = "
                                                UPDATE company_agm_information
                                                SET
                                                    last_agm_held_on = :last_agm_held_on,
                                                    year_end = :year_end,
                                                    reserve_surplus = :reserve_surplus,
                                                    comprehensive_income = :comprehensive_income,
                                                    updated_by = :updated_by,
                                                    updated_at = NOW()  -- Use NOW() function here
                                                WHERE
                                                    company_id = :company_id
                                            ";

                                            // Execute the UPDATE query
                                            $stmt = $conn->prepare($updateQuery);
                                            $stmt->execute($updateData);
                                            echo "Update finished for AGM...\n";
                                        } else {
                                            echo "No info available for AGM. Insert started for AGM...\n";

                                            // Insert the company code into the database
                                            // Get the current date and time
                                            $currentDatetime = date('Y-m-d H:i:s');

                                            // Check if last_agm_held_on is 'N/A'
                                            if (strtolower($lastAgmHeldOn) == 'n/a' || strtolower($lastAgmHeldOn) == '') {
                                                echo "Last AGM date not available for company -> '$search_code'. Inserting AGM date to -> [NULL].\n";
                                                $lastAgmHeldOn = null;
                                            }

                                            // Check if comprehensive_income is empty or not available
                                            if (empty($comprehensiveIncome)) {
                                                $comprehensiveIncome = null; // or set a default value if needed
                                            }

                                            // Create a dictionary of values for insertion
                                            $insertData = [
                                                'company_id' => $instrumentId,
                                                'last_agm_held_on' => $lastAgmHeldOn,
                                                'right_issue' => 'nothing',
                                                'year_end' => $yearEnd,
                                                'reserve_surplus' => $reserveSurplus,
                                                'comprehensive_income' => $comprehensiveIncome,
                                                'created_by' => 1,
                                                'updated_by' => 1,
                                                'created_at' => $currentDatetime,
                                                'updated_at' => $currentDatetime
                                            ];

                                            echo "Inserting percentage: $percentage\n";

                                            // SQL INSERT query with named placeholders
                                            $insertQuery = "
                                                INSERT INTO company_agm_information
                                                (company_id, last_agm_held_on, right_issue, year_end, reserve_surplus,
                                                comprehensive_income, created_by, updated_by, created_at, updated_at)
                                                VALUES
                                                (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
                                            ";

                                            // // Execute the INSERT query
                                            // echo "Insert Query: $insertQuery\n";
                                            // print_r($insertData);
                                            // if ($stmt === false) {
                                            //     die('Error in prepare(): ' . htmlspecialchars($conn->error) . ', Query: ' . $insertQuery);
                                            // }

                                            // $result = $stmt->execute($insertData);

                                            // if ($result === false) {
                                            //     die('Error in execute(): ' . htmlspecialchars($stmt->error) . ', Query: ' . $insertQuery);
                                            // }
                                            // echo "AGM info for Company -> '$search_code' inserted into the database.\n";

                                            // Prepare and execute the INSERT query
                                            $stmt = $conn->prepare($insertQuery);
                                            if ($stmt) {
                                                // Bind parameters
                                                $stmt->bind_param(
                                                    "iissddiiss",
                                                    $insertData['company_id'],
                                                    $insertData['last_agm_held_on'],
                                                    $insertData['right_issue'],
                                                    $insertData['year_end'],
                                                    $insertData['reserve_surplus'],
                                                    $insertData['comprehensive_income'],
                                                    $insertData['created_by'],
                                                    $insertData['updated_by'],
                                                    $insertData['created_at'],
                                                    $insertData['updated_at']
                                                );

                                                // Execute the INSERT query
                                                if ($stmt->execute()) {
                                                    echo "AGM info for Company -> '$search_code' inserted into the database.\n";
                                                } else {
                                                    echo "Error inserting AGM info for Company -> '$search_code': " . $stmt->error . "\n";
                                                }
                                            } else {
                                                echo "Error in prepare(): " . htmlspecialchars($conn->error) . ", Query: " . $insertQuery . "\n";
                                            }

                                        }
                                    } else {
                                        echo "Instrument code for company -> '$search_code' not found.\n";
                                    }

                                    // If a record exists, update it; otherwise, insert a new record
                                    if ($existingRecord) {
                                        echo "Company Basic Information already available. Update started for Company -> '$search_code'...\n";
                                        $currentDatetime = date('Y-m-d H:i:s');

                                        // SQL UPDATE query with named placeholders
                                        $updateQuery = "
                                            UPDATE company_basic_information
                                            SET
                                                company_name = ?,
                                                code = ?,
                                                xcode = ?,
                                                scrip_code_dse = ?,
                                                listing_year_dse = ?,
                                                instrument_id = ?,
                                                market_category = ?,
                                                electronic_share = ?,
                                                head_office_address = ?,
                                                factory_office_address = ?,
                                                fax = ?,
                                                phone = ?,
                                                updated_by = ?,
                                                updated_at = ?
                                            WHERE
                                                code = ?
                                        ";

                                        // Prepare and execute the UPDATE query
                                        $stmt = $conn->prepare($updateQuery);
                                        $stmt->bind_param(
                                            "isssdsdsiississ",
                                            $updateData['company_name'],
                                            $updateData['code'],
                                            $updateData['xcode'],
                                            $updateData['scrip_code_dse'],
                                            $updateData['listing_year_dse'],
                                            $updateData['instrument_id'],
                                            $updateData['market_category'],
                                            $updateData['electronic_share'],
                                            $updateData['head_office_address'],
                                            $updateData['factory_office_address'],
                                            $updateData['fax'],
                                            $updateData['phone'],
                                            $updateData['updated_by'],
                                            $updateData['updated_at'],
                                            $updateData['code']
                                        );


                                        if ($stmt->execute()) {
                                            echo "Company Basic Information updated for Company -> '$search_code'.\n";
                                        } else {
                                            echo "Error updating Company Basic Information for Company -> '$search_code': " . $stmt->error . "\n";
                                        }
                                    } else {
                                        echo "Company Basic Information not available. Insert started for Company -> '$search_code'...\n";

                                        // Insert the company code into the database
                                        // Get the current date and time
                                        $currentDatetime = date('Y-m-d H:i:s');

                                        // SQL INSERT query with named placeholders
                                        $insertQuery = "
                                            INSERT INTO company_basic_information
                                            (company_name, code, xcode, company_description, incorporation_date,
                                            scrip_code_dse, scrip_code_cse, listing_year_dse, listing_year_cse,
                                            instrument_id, market_category, electronic_share, corporate_office_address,
                                            head_office_address, factory_office_address, fax, phone, created_by, updated_by,
                                            created_at, updated_at)
                                            VALUES
                                            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                        ";

                                        // Prepare and execute the INSERT query
                                        $stmt = $conn->prepare($insertQuery);
                                        $stmt->bind_param(
                                            "ssssssisssssssssssssss",
                                            $insertData['company_name'],
                                            $insertData['code'],
                                            $insertData['xcode'],
                                            $insertData['company_description'],
                                            $insertData['incorporation_date'],
                                            $insertData['scrip_code_dse'],
                                            $insertData['scrip_code_cse'],
                                            $insertData['listing_year_dse'],
                                            $insertData['listing_year_cse'],
                                            $insertData['instrument_id'],
                                            $insertData['market_category'],
                                            $insertData['electronic_share'],
                                            $insertData['corporate_office_address'],
                                            $insertData['head_office_address'],
                                            $insertData['factory_office_address'],
                                            $insertData['fax'],
                                            $insertData['phone'],
                                            $insertData['created_by'],
                                            $insertData['updated_by'],
                                            $insertData['created_at'],
                                            $insertData['updated_at']
                                        );

                                        if ($stmt->execute()) {
                                            echo "Company Basic Information for Company -> '$search_code' inserted into the database.\n";
                                        } else {
                                            echo "Error inserting Company Basic Information for Company -> '$search_code': " . $stmt->error . "\n";
                                        }
                                    }
                                } catch (PDOException $e) {
                                    echo "Error inserting data: " . $e->getMessage() . "\n";
                                }


                            } else {
                                echo "Company name not found within <i> tag for Company -> '$search_code'.\n";
                            }
                        } else {
                            echo "HTML element not found for Company -> '$search_code'.\n";
                        }
                    } else {
                        echo "Company with code '$search_code' does not exist.\n";
                    }
                } else {
                    echo "Trading code information not found in the table.\n";
                }
            } else {
                echo "$search_code company not found in DSE. Skipping insertion.\n";
            }
        } else {
            echo "HTTP request failed. Skipping.\n";
        }

        echo "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    // Close the MySQLi connection
    $conn->close();
}
?>
