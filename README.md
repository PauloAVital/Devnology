# Projeto Devnology
Teste para vaga FullStack


---
## Subindo o Docker para rodar o app
1. **sudo docker-compose build app**
2. **sudo docker-compose up -d**
3. ![Título da imagem](public/img/rodar-docker.png)

---
## Instalar as dependências do composer
4. **sudo docker-compose exec app composer install**
5. **sudo docker-compose exec app composer update**
6. ![Título da imagem](public/img/composer_install.png)

---

## crie uma chave para o artisan
7. **sudo docker-compose exec app php artisan key:generate**
8. ![Título da imagem](public/img/key.png)
---

9. Rode o Migrate **sudo docker-compose exec app php artisan migrate:refresh --seed**
![Título da imagem](public/img/migrate.png)
---

10. Acesse o **_http://localhost:8000/_**
11. ![Título da imagem](public/img/BackEnd.png)
12. Crie seu usuario para administrar o BackEnd
13. ![Título da imagem](public/img/criar-usuario.png)
14. Verifique os logs de consulta das Apis
15. ![Título da imagem](public/img/log-consulta-api.png)

---

16. Criação do FrontEnd - React
17. Para executar entra no diretorio **cd app-devnology**
18. Dentro do diretório para subir o servidor react **npm start**
19. Acesse o **http://localhost:3000/**
20. ![Título da imagem](public/img/FrontEnd.png)