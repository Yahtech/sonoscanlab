<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $service = htmlspecialchars(trim($_POST['service']));
    $message = htmlspecialchars(trim($_POST['message']));
    
    // Validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    }
    
    if (empty($message)) {
        $errors[] = "Please describe your symptoms or concerns";
    }
    
    // If no errors, proceed with email
    if (empty($errors)) {
        // Email configuration
        $to = "yahyasiyaka@gmail.com"; // Change this to your email
        $subject = "New Online Consultation Request - Sonoscan Lab";
        
        // Email template
        $email_template = "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #1a76d1; color: white; padding: 20px; text-align: center; }
                .content { background: #f9f9f9; padding: 20px; }
                .field { margin-bottom: 15px; }
                .field-label { font-weight: bold; color: #1a76d1; }
                .footer { background: #333; color: white; padding: 15px; text-align: center; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>New Online Consultation Request</h2>
                    <p>Sonoscan Medical Diagnostic Lab</p>
                </div>
                <div class='content'>
                    <div class='field'>
                        <span class='field-label'>Patient Name:</span> $name
                    </div>
                    <div class='field'>
                        <span class='field-label'>Email Address:</span> $email
                    </div>
                    <div class='field'>
                        <span class='field-label'>Phone Number:</span> $phone
                    </div>
                    <div class='field'>
                        <span class='field-label'>Consultation Type:</span> $service
                    </div>
                    <div class='field'>
                        <span class='field-label'>Symptoms/Concerns:</span><br>
                        $message
                    </div>
                    <div class='field'>
                        <span class='field-label'>Submission Date:</span> " . date('F j, Y, g:i a') . "
                    </div>
                </div>
                <div class='footer'>
                    <p>This email was sent from the Online Consultation form on Sonoscan Lab website.</p>
                    <p>Please respond to this consultation request within 24 hours.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        // Email headers
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Sonoscan Lab <noreply@sonoscanlab.com>" . "\r\n";
        $headers .= "Reply-To: $email" . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        // Send email
        if (mail($to, $subject, $email_template, $headers)) {
            // Send confirmation email to patient
            $patient_subject = "Consultation Request Received - Sonoscan Lab";
            $patient_template = "
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: #1a76d1; color: white; padding: 20px; text-align: center; }
                    .content { background: #f9f9f9; padding: 20px; }
                    .footer { background: #333; color: white; padding: 15px; text-align: center; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>Consultation Request Received</h2>
                    </div>
                    <div class='content'>
                        <p>Dear $name,</p>
                        <p>Thank you for requesting an online consultation with Sonoscan Lab. We have received your request with the following details:</p>
                        <ul>
                            <li><strong>Consultation Type:</strong> $service</li>
                            <li><strong>Phone:</strong> $phone</li>
                            <li><strong>Submission Date:</strong> " . date('F j, Y, g:i a') . "</li>
                        </ul>
                        <p>Our medical team will review your request and contact you within 24 hours to schedule your consultation.</p>
                        <p>If you have any urgent concerns, please call us directly at +2347031004818.</p>
                        <p>Best regards,<br>Sonoscan Medical Diagnostic Lab Team</p>
                    </div>
                    <div class='footer'>
                        <p>This is an automated confirmation. Please do not reply to this email.</p>
                    </div>
                </div>
            </body>
            </html>
            ";
            
            $patient_headers = "MIME-Version: 1.0" . "\r\n";
            $patient_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $patient_headers .= "From: Sonoscan Lab <noreply@sonoscanlab.com>" . "\r\n";
            
            mail($email, $patient_subject, $patient_template, $patient_headers);
            
            $response = [
                'status' => 'success',
                'message' => 'Thank you! Your consultation request has been submitted successfully. We will contact you within 24 hours.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Sorry, there was an error submitting your request. Please try again or call us directly.'
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Please correct the following errors: ' . implode(', ', $errors)
        ];
    }
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>