@echo off
echo Création de la table messages...

mysql -u root -p blog_social < create-messages-table.sql

echo Table messages créée avec succès!
pause