
 STAGE = "DEV";
 BASE_URL = "";
switch (STAGE) {
    case "PROD":
        BASE_URL = '';
        break;
    case "TEST":
        BASE_URL = '';
        break; 
    case "DEV":
        BASE_URL = 'http://localhost/clinica_dental/public/index.php/';
        break;
    default:
        break;
}