window.formhash = function (form, password) {
    // Create a new element input, this will be our hashed password field.
    var p = document.createElement('input');

    // Add the new element to our form.
    form.appendChild(p);
    p.name = 'p';
    p.type = 'hidden';
    p.value = hex_sha512(password.value);

    // Create a new element input, this will be our md5 hashed password field.
    var pmd5 = document.createElement('input');

    // Add the new md5 element to our form.
    form.appendChild(pmd5);
    pmd5.name = 'pmd5';
    pmd5.type = 'hidden';
    pmd5.value = md5(password.value);

    // Make sure the plaintext password doesn't get sent.
    password.value = '';
}
