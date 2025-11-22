<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
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
    
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, proceed with email
    if (empty($errors)) {
        // Email configuration
        $to = "sonoscanservices@gmail.com"; // Change this to your email
        $email_subject = "New Contact Form Message: " . $subject;
        
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
                    <h2>New Contact Form Message</h2>
                    <p>Sonoscan Medical Diagnostic Lab</p>
                </div>
                <div class='content'>
                    <div class='field'>
                        <span class='field-label'>Name:</span> $name
                    </div>
                    <div class='field'>
                        <span class='field-label'>Email Address:</span> $email
                    </div>
                    <div class='field'>
                        <span class='field-label'>Subject:</span> $subject
                    </div>
                    <div class='field'>
                        <span class='field-label'>Message:</span><br>
                        $message
                    </div>
                    <div class='field'>
                        <span class='field-label'>Submission Date:</span> " . date('F j, Y, g:i a') . "
                    </div>
                </div>
                <div class='footer'>
                    <p>This email was sent from the Contact form on Sonoscan Lab website.</p>
                    <p>Please respond to this inquiry within 24 hours.</p>
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
        if (mail($to, $email_subject, $email_template, $headers)) {
            // Send confirmation email to user
            $user_subject = "Thank You for Contacting Sonoscan Lab";
            $user_template = "
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
                        <h2>Thank You for Contacting Us</h2>
                    </div>
                    <div class='content'>
                        <p>Dear $name,</p>
                        <p>Thank you for reaching out to Sonoscan Medical Diagnostic Lab. We have received your message and our team will get back to you within 24 hours.</p>
                        <p><strong>Here's a summary of your inquiry:</strong></p>
                        <ul>
                            <li><strong>Subject:</strong> $subject</li>
                            <li><strong>Submission Date:</strong> " . date('F j, Y, g:i a') . "</li>
                        </ul>
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
            
            $user_headers = "MIME-Version: 1.0" . "\r\n";
            $user_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $user_headers .= "From: Sonoscan Lab <noreply@sonoscanlab.com>" . "\r\n";
            
            mail($email, $user_subject, $user_template, $user_headers);
            
            $response = [
                'status' => 'success',
                'message' => 'Thank you! Your message has been sent successfully. We will contact you within 24 hours.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Sorry, there was an error sending your message. Please try again or call us directly.'
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