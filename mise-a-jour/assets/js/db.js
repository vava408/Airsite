// db.js

import mysql from 'mysql';

const config = {
  host: 'mysql-airbot.alwaysdata.net',
  user: 'airbot',
  password: 'vava11ba',
  database: 'airbot_stats',
};

export async function connectToDatabase() {
  try {
    const connection = await mysql.createConnection(config);
    console.log('Connexion à la base de données réussie.');
    return connection;
  } catch (error) {
    console.error('Erreur de connexion à la base de données :', error.message);
    throw error;
  }
}
