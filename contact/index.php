<?php

//////////////////////////////////////////////////////////
/////////////////////MODULE/////CLASS/////////////////////
//////////////////////////////////////////////////////////

class Mail
{
    /**
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $content
     * @return bool
     */
    public static function send($to = 'morgosusin@gmail.com', $subject, $content, $from = 'martin@toms.click')
    {
        $headers = "From: $from";
        $headers .= "\nMIME-Version: 1.0\n";
        $headers .= "Content-Type: text/html; charset=\"utf-8\"\n";

        if (self::validateMail($to)) {
            return mb_send_mail($to, $subject, $content, $headers);
        }
        return false;
    }

    /**
     * @param string $email
     * @return mixed
     */
    private static function validateMail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}

//////////////////////////////////////////////////////////
/////////////////////MODULE////SCRIPT/////////////////////
//////////////////////////////////////////////////////////

//Deal form
if (isset($_POST['submitProposal']) &&
    isset($_POST['proposal']) && $_POST['proposal'] !== '' &&
    isset($_POST['desire']) && $_POST['desire'] !== '' &&
    isset($_POST['name']) && $_POST['name'] !== '' &&
    isset($_POST['email']) && $_POST['email'] !== '') {

    if (Mail::send(
        'morgosusin@gmail.com',
        'Deal form was submitted on toms.click',
        'Name: ' . $_POST['name'] . '<br>' .
        $_POST['proposal'] . '<br>' .
        $_POST['desire'] . '<br>Contact email: ' .
        $_POST['email'],
        'toms.click@toms.click'
    )) {
        header('Location: https://www.toms.click/en-us/notice/success');
        exit;
    }
    //failure sending form
} elseif (isset($_POST['submitContactForm'])) {
    if (isset($_POST['classification']) && $_POST['classification'] !== '' &&
        isset($_POST['name']) && $_POST['name'] !== '' &&
        isset($_POST['email']) && $_POST['email'] !== '' &&
        isset($_POST['subject']) && $_POST['subject'] !== ''
        && isset($_POST['content']) && $_POST['content'] !== '') {
        if (Mail::send(
            'morgosusin@gmail.com',
            'Contact form: ' . $_POST['classification'],
            'Name: ' . $_POST['name'] . '<br>' .
            'Subject: ' . $_POST['subject'] . '<br>Content:' .
            $_POST['content'] . '<br>Contact email: ' .
            $_POST['email'],
            'toms.click@toms.click')) {
            header('Location: https://www.toms.click/en-us/notice/success');
            exit;
        } else {
            header('Location: https://www.toms.click/en-us/notice/failure');
            exit;
        }
    } else {
        header('Location: https://www.toms.click/en-us/notice/failure');
        exit;
    }

} elseif (isset($_POST['submitProposal'])) {
    header('Location: https://www.toms.click/en-us/notice/failure');
    exit;
} else {
//////////////////////////////////////////////////////////
/////////////////////MODULE//////VIEW/////////////////////
//////////////////////////////////////////////////////////
    ?>
    <!DOCTYPE HTML>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Contact | Toms.click | Personal website of a random student</title>
        <meta name="description"
              content="Contact form for the Toms.click web application">
        <meta name="keywords" content="contact form, Martin Toms, contact, report">
        <meta name="author" content="Martin Toms">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Spectral&amp;subset=cyrillic,latin-ext" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/contact/contact.css?v=2.0.0">
        <!--suppress HtmlUnknownTarget this is here for both subdomain and uri compatibility -->
        <link rel="stylesheet" type="text/css" href="/contact.css?v=2.0.0">
    
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
    </head>
    <body id="contact-module">
    <a href="https://www.toms.click" class="return-link">Back to Toms.click</a>
    <p>I don't guarantee that this form works, worst case scenario - just ask me in person or HMU some other way ;)</p>
    <form method="post" autocomplete="off">
        <label for="classification">Type of message</label>
        <select name="classification" class="pointer" required>
            <option selected="selected" value="Bug report">Bug report</option>
            <option value="Website suggestion">Website suggestion</option>
            <option value="Article correction">Article correction</option>
            <option value="Website-related request">Website-related request</option>
            <option value="Other">Other</option>
        </select>
        <label for="name">Who are you?</label>
        <input name="name" type="text" placeholder="Name" maxlength="255" minlength="4" required/>
        <label for="email">What's your email?</label>
        <input name="email" minlength="5" type="email" placeholder="Email" required/>
        <label for="subject">Subject:</label>
        <input name="subject" type="text" placeholder="Subject" required/>
        <label for="content">Message:</label>
        <textarea name="content"
                  placeholder="Add a TLDR; to the top if you're writing a longer message and want to make sure I read it"
                  required></textarea>
        <input class="contact-submit-button pointer" name="submitContactForm" onclick="confirm('Assuming no errors occurred, the message will be sent. If it fails, just use Martin Toms <Morgosusin@gmail.com>')" type="submit"/>
    </form>
    <a href="https://www.toms.click" class="return-link">Back to Toms.click</a>
    </body>
    </html>
    <?php
}
