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
