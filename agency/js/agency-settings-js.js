let timeout;

function showPopup() {
    const popup = document.getElementById("popup");
    const button = document.querySelector(".profile-button");
    const buttonRect = button.getBoundingClientRect();

    clearTimeout(timeout);
    popup.style.display = "block";
    popup.style.left = buttonRect.left + "px";
    popup.style.top = buttonRect.bottom + "px";
}

function hidePopup() {
    const popup = document.getElementById("popup");
    timeout = setTimeout(() => {
        popup.style.display = "none";
    }, 200);
}

const profileButton = document.querySelector(".profile-button");
profileButton.addEventListener("mouseenter", showPopup);
profileButton.addEventListener("mouseleave", hidePopup);

const popup = document.getElementById("popup");
popup.addEventListener("mouseenter", () => clearTimeout(timeout));
popup.addEventListener("mouseleave", hidePopup);

function showBasicInfo() {
    const basicInfoSection = document.getElementById('basic-info-section');
    const accountSettingsSection = document.getElementById('account-settings-section');
    basicInfoSection.style.display = 'flex';
    accountSettingsSection.style.display = 'none';
    localStorage.setItem('activeSection', 'basic-info-section');
}

function showAccountSettings() {
    const basicInfoSection = document.getElementById('basic-info-section');
    const accountSettingsSection = document.getElementById('account-settings-section');
    basicInfoSection.style.display = 'none';
    accountSettingsSection.style.display = 'flex';
    localStorage.setItem('activeSection', 'account-settings-section');
}

function setPageOnLoad() {
    const activeSection = localStorage.getItem('activeSection');
    if (activeSection === 'account-settings-section') {
        showAccountSettings();
    } else {
        showBasicInfo();
    }
}
window.addEventListener('load', setPageOnLoad);




function showAgencyNameEdit() {
    const agencyNameEditFalse = document.getElementById('agency-name-edit-false');
    const agencyNameEditTrue = document.getElementById('agency-name-edit-true');
    const agencyNameEditCancel = document.getElementById('agency-name-edit-cancel');
    const agencyNameEditIcon = document.getElementById('agency-name-edit-icon');
     const agencyNameSubmit = document.getElementById('agency-name-submit-button');

    agencyNameEditFalse.style.display = 'none';
    agencyNameEditTrue.style.display = 'block';
    agencyNameEditCancel.style.display = 'block';
    agencyNameEditIcon.style.display = 'none';
    agencyNameSubmit.style.display = 'block';
}

function hideAgencyNameEditIcon() {
    const agencyNameEditFalse = document.getElementById('agency-name-edit-false');
    const agencyNameEditTrue = document.getElementById('agency-name-edit-true');
    const agencyNameEditCancel = document.getElementById('agency-name-edit-cancel');
    const agencyNameEditIcon = document.getElementById('agency-name-edit-icon');
    const agencyNameSubmit = document.getElementById('agency-name-submit-button');

    agencyNameEditTrue.style.display = 'none';
    agencyNameEditFalse.style.display = 'block';
    agencyNameEditCancel.style.display = 'none';
    agencyNameEditIcon.style.display = 'block';
    agencyNameSubmit.style.display = 'none';


}

function showUsernameEdit() {
    const usernameEditFalse = document.getElementById('username-edit-false');
    const usernameEditTrue = document.getElementById('username-edit-true');
    const usernameEditCancel = document.getElementById('username-edit-cancel');
    const usernameEditIcon = document.getElementById('username-edit-icon');
    const usernameSubmit = document.getElementById('username-submit-button');

    usernameEditFalse.style.display = 'none';
    usernameEditTrue.style.display = 'block';
    usernameEditCancel.style.display = 'block';
    usernameEditIcon.style.display = 'none';
    usernameSubmit.style.display = 'block';

}

function hideUsernameEdit() {
    const usernameEditFalse = document.getElementById('username-edit-false');
    const usernameEditTrue = document.getElementById('username-edit-true');
    const usernameEditCancel = document.getElementById('username-edit-cancel');
    const usernameEditIcon = document.getElementById('username-edit-icon');
    const usernameSubmit = document.getElementById('username-submit-button');

    usernameEditFalse.style.display = 'block';
    usernameEditTrue.style.display = 'none';
    usernameEditCancel.style.display = 'none';
    usernameEditIcon.style.display = 'block';
    usernameSubmit.style.display = 'none';
}

function showLicenseEdit() {
    const licenseEditFalse = document.getElementById('license-edit-false');
    const licenseEditTrue = document.getElementById('license-edit-true');
    const licenseEditCancel = document.getElementById('license-edit-cancel');
    const licenseEditIcon = document.getElementById('license-edit-icon');
    const licenseSubmit = document.getElementById('license-submit-button');

    licenseEditFalse.style.display = 'none';
    licenseEditTrue.style.display = 'block';
    licenseEditCancel.style.display = 'block';
    licenseEditIcon.style.display = 'none';
    licenseSubmit.style.display = 'block';
}

function hideLicenseEditIcon() {
    const licenseEditFalse = document.getElementById('license-edit-false');
    const licenseEditTrue = document.getElementById('license-edit-true');
    const licenseEditCancel = document.getElementById('license-edit-cancel');
    const licenseEditIcon = document.getElementById('license-edit-icon');
    const licenseSubmit = document.getElementById('license-submit-button');


    licenseEditFalse.style.display = 'block';
    licenseEditTrue.style.display = 'none';
    licenseEditCancel.style.display = 'none';
    licenseEditIcon.style.display = 'block';
    licenseSubmit.style.display = 'none';
}

function showEmailEdit() {
    const emailEditFalse = document.getElementById('email-edit-false');
    const emailEditTrue = document.getElementById('email-edit-true');
    const emailEditCancel = document.getElementById('email-edit-cancel');
    const emailEditIcon = document.getElementById('email-edit-icon');
    const emailSubmit = document.getElementById('email-submit-button');


    emailEditFalse.style.display = 'none';
    emailEditTrue.style.display = 'block';
    emailEditCancel.style.display = 'block';
    emailEditIcon.style.display = 'none';
    emailSubmit.style.display = 'block';
}

function hideEmailEditIcon() {
    const emailEditFalse = document.getElementById('email-edit-false');
    const emailEditTrue = document.getElementById('email-edit-true');
    const emailEditCancel = document.getElementById('email-edit-cancel');
    const emailEditIcon = document.getElementById('email-edit-icon');
    const emailSubmit = document.getElementById('email-submit-button');

    emailEditFalse.style.display = 'block';
    emailEditTrue.style.display = 'none';
    emailEditCancel.style.display = 'none';
    emailEditIcon.style.display = 'block';
    emailSubmit.style.display = 'none';
}

function showPasswordEdit() {
    const passwordEditFalse = document.getElementById('password-edit-false');
    const passwordEditTrue = document.getElementById('password-edit-true');
    const passwordEditCancel = document.getElementById('password-edit-cancel');
    const passwordEditIcon = document.getElementById('password-edit-icon');
    const passwordEditNewTrue = document.getElementById('password-edit-true-new');
    const passwordSubmit = document.getElementById('password-submit-button');


    passwordEditFalse.style.display = 'none';
    passwordEditTrue.style.display = 'block';
    passwordEditCancel.style.display = 'block';
    passwordEditIcon.style.display = 'none';
    passwordEditNewTrue.style.display ='block';
    passwordSubmit.style.display = 'block';
}

function hidePasswordEditIcon() {
    const passwordEditFalse = document.getElementById('password-edit-false');
    const passwordEditTrue = document.getElementById('password-edit-true');
    const passwordEditCancel = document.getElementById('password-edit-cancel');
    const passwordEditIcon = document.getElementById('password-edit-icon');
    const passwordEditNewTrue = document.getElementById('password-edit-true-new');
    const passwordSubmit = document.getElementById('password-submit-button');



    passwordEditFalse.style.display = 'block';
    passwordEditTrue.style.display = 'none';
    passwordEditCancel.style.display = 'none';
    passwordEditIcon.style.display = 'block';
    passwordEditNewTrue.style.display ='none';
    passwordSubmit.style.display = 'none';
}

function showAddressEdit() {
    const addressEditFalse = document.getElementById('address-edit-false');
    const addressEditTrue = document.getElementById('address-edit-true');
    const addressEditCancel = document.getElementById('address-edit-cancel');
    const addressEditIcon = document.getElementById('address-edit-icon');
    const addressSubmit = document.getElementById('address-submit-button');

    addressEditFalse.style.display = 'none';
    addressEditTrue.style.display = 'block';
    addressEditCancel.style.display = 'block';
    addressEditIcon.style.display = 'none';
    addressSubmit.style.display = 'block';
}

function hideAddressEditIcon() {
    const addressEditFalse = document.getElementById('address-edit-false');
    const addressEditTrue = document.getElementById('address-edit-true');
    const addressEditCancel = document.getElementById('address-edit-cancel');
    const addressEditIcon = document.getElementById('address-edit-icon');
    const addressSubmit = document.getElementById('address-submit-button');

    addressEditFalse.style.display = 'block';
    addressEditTrue.style.display = 'none';
    addressEditCancel.style.display = 'none';
    addressEditIcon.style.display = 'block';
    addressSubmit.style.display = 'none';
}