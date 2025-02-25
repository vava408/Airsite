// script.js

import { connectToDatabase } from './db.js';

// Fonction principale
async function main() {
    let connection;

    try {
        // Connexion à la base de données
        connection = await connectToDatabase();

        // Exécution de la requête MySQL
        const [rows, fields] = await connection.execute('SELECT * FROM updates ORDER BY date DESC LIMIT 5');

        console.log('Résultat de la requête :', rows);

        // Affichage des mises à jour sur la page
        const updatesContainer = document.getElementById('updates-container');

        rows.forEach(update => {
            const updateCard = document.createElement('div');
            updateCard.classList.add('update-card');

            const nomElement = document.createElement('div');
            nomElement.classList.add('update-nom');
            nomElement.textContent = `Nom: ${update.nom}`;

            const contentElement = document.createElement('div');
            contentElement.classList.add('update-content');
            contentElement.textContent = `Description: ${update.description}`;

            const versionElement = document.createElement('div');
            versionElement.classList.add('update-version');
            versionElement.textContent = `Version: ${update.version}`;

            const dateElement = document.createElement('div');
            dateElement.classList.add('update-date');
            dateElement.textContent = new Date(update.date).toDateString();

            updateCard.appendChild(nomElement);
            updateCard.appendChild(contentElement);
            updateCard.appendChild(versionElement);
            updateCard.appendChild(dateElement);

            updatesContainer.appendChild(updateCard);
        });
    } catch (error) {
        console.error('Une erreur s\'est produite :', error.message);
    } finally {
        // Fermer la connexion à la base de données après utilisation
        if (connection) {
            await connection.end();
        }
    }
}

// Appel de la fonction main après le chargement du document
document.addEventListener('DOMContentLoaded', main);
