Design and implement an API for an app that manages keys and their translations. 

## Acceptance criteria
 

### API should provide this functionality:
- API token authentication
- List available languages
- Manage keys
    - List
    - Create
    - Rename
    - Delete
- Manage translations
    - Update values
    - Update using machine translation (any translation can be used as a source)
        - Google Cloud Translation API should be used
            - [TranslateClient by Google](https://googleapis.github.io/google-cloud-php/#/docs/google-cloud/v0.142.0/translate/v2/translateclient)
            - [Basics](https://cloud.google.com/translate/docs/basic/translating-text)
            - Credentails are provided in `practical-task-0c6409f04b3a.json`
            - Supported languages ([Link 1](https://cloud.google.com/translate/docs/languages), [Link 2](https://cloud.google.com/translate/docs/basic/discovering-supported-languages))
        
- Export translations in zip
    - In .json format with 1 file per language ([language-iso].json)
    - In .yaml with all languages in 1 file (translations.yaml)
 

###  Languages should:
- Have a name
- Have an iso code
- Have Right To Left (RTL) flag
- Be referred to using their ISO code
- Be generated using DB migration or any other similar method (5 languages will be enough, with at least 1 RTL language)
 

### Key should:
- Have a name
- Be unique based on the name
- Be accessed using generated ID trough API
- Have one translation per language when created (can be empty)


### Translation should have:
- A value
- An associated language


### API Tokens should:
- Be stored in the database
- Be unique
- Be one of 2 types (read-only, read-write)
- Be generated using DB migration or any other similar method (1 read-only and 1 read-write will be enough)


### You can:
- Use any PHP framework you are comfortable with


### You have to demonstrate in an HTTP client of your choice:
- How languages are listed
- How keys are created
- How duplicate language translations are not being added
- How translations are updated
- How translations are updated using Machine Translation
- How export works for both formats
- How the authentication works
 
### Ho it works:
- Please be sure you have docker (with compose) OR local mysql 5.7 running at your server
- then:
```
cp .env.dist .env
```
- add your db credentials in .env file
- afterwards:
```
docker-compose up (-d if you prefer)
```
- next (load fixtures: languages, keys, preset translations):
```
./scripts/prepare-app.sh
```
- next (fire the server):
```
export GOOGLE_APPLICATION_CREDENTIALS=/your-absolute-path/project_name/practical-task-0c6409f04b3a.json && ./bin/console server:run
```
- The documentation with all endpoints and some specificsations regarding them: 
```
http://localhost:[port-you-ran-the-app]/doc/
```
- Db query explain:
![Alt text](db-performance-dump-screenshot.png?raw=true "db-screenshot")

- Enjoy!