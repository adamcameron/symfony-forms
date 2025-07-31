document.addEventListener('DOMContentLoaded', function() {
    const givenName = document.getElementById('user_givenName');
    const familyName = document.getElementById('user_familyName');
    const loginId = document.getElementById('user_loginId');
    let loginIdManuallyEdited = false;

    function updateLoginId() {
        if (loginIdManuallyEdited) {
            return;
        }
        if (givenName && familyName && loginId) {
            loginId.value = (givenName.value + '.' + familyName.value).toLowerCase();
        }
    }

    if (loginId) {
        loginId.addEventListener('input', function() {
            loginIdManuallyEdited = true;
        });
    }

    if (givenName && familyName) {
        givenName.addEventListener('input', updateLoginId);
        familyName.addEventListener('input', updateLoginId);
    }
});
