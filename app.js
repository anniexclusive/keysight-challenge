const process = require('process');
const fs = require('fs');
const path = require('path');

if (process.argv.length <= 2) {
    console.error('Please provide a filepath or directory as a command line argument.');
    process.exit(1);
}

const rootProgramPath = process.argv[2];

if (path.basename(rootProgramPath) !== 'root.prog') {
    console.log('invalid filepath, please input a valid root program file path as argument');
    process.exit(1);
}

console.log(path.basename(rootProgramPath))
displayImportStructure(rootProgramPath);

function displayImportStructure(rootProgramPath, indentation = '   ') {
    const fileContent = fs.readFileSync(rootProgramPath, 'utf8');

    // Regular expression to find import statements
    const importRegex = /import\s+(.+);/g;
    let match;

    while ((match = importRegex.exec(fileContent)) !== null) {
        const importPath = match[1].trim();

        // Print the import path with proper indentation
        console.log(indentation + path.basename(importPath));

        // Recursive call
        const importFilePath = path.join(path.dirname(rootProgramPath), importPath);
        displayImportStructure(importFilePath, indentation + '   ');
    }
}
