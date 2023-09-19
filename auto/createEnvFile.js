const fs = require('fs');

// Define the content for your .env file
const envContent = `
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rumahsakit
DB_USERNAME=root
DB_PASSWORD=
`;

// Specify the path to your .env file
const envFilePath = '.env';

// Write the content to the .env file
fs.writeFileSync(envFilePath, envContent);

// use in terminal: node createEnvFile.js
// install library to read .env file
// composer require vlucas/phpdotenv

console.log('.env file created successfully.');

