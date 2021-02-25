# projeto_urls
 
Após baixar o projeto em sua máquina, siga as instruções:

1- Execute o comando composer install no terminal em seu projeto

2- Copie o arquivo .env.example e renomeie para .env

3- No arquivo .env configure o seu banco de dados

4- Crie uma nova chave para sua aplicação com o comando php artisan key:generate

5- Execute o comando php artisan migrate --seed para criar as tabelas e o usuário teste (usuario: teste01 senha: teste01)

6- Para testar o script CRON no localhost basta rodar o comando php artisan schedule:run que iniciara a verificação de todas as URLs

Obs: O contexto do projeto encontra-se no arquivo Contextualização.pdf
