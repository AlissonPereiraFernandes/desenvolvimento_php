# Desenvolvimento Web com PHP (MVC)

Projeto  em Desenvolvimento Web com PHP, estruturado no padrão MVC (Model–View–Controller), utilizando Composer, rotas customizadas e organização modular para facilitar manutenção e escalabilidade.

---

## 🚀 Tecnologias Utilizadas

- PHP
- HTML5
- CSS3
- JavaScript
- Composer
- Apache (XAMPP)
- Git & GitHub

---

## 🧠 Arquitetura

O projeto segue o padrão MVC, separando responsabilidades da aplicação em:

- **Modelo** → regra de negócio e acesso a dados
- **Controlador** → controle do fluxo da aplicação
- **View** → apresentação (HTML/CSS/JS)

---

## 📂 Estrutura do Projeto

```
desenvolvimento_web_php/
├── index.php              
├── rotas.php              
├── .htaccess              
├── composer.json          
│
├── sistema/
│   ├── Configuracao.php
│   ├── Controlador/
│   │   └── SiteControlador.php
│   ├── Modelo/
│   │   └── PostModelo.php
│   ├── Nucleo/
│   │   ├── Conexao.php
│   │   ├── Controlador.php
│   │   ├── Helpers.php
│   │   └── Mensagem.php
│   └── Suporte/
│       └── Template.php
│
├── templates/
│   ├── assets/
│   │   ├── css/
│   │   ├── img/
│   │   └── js/
│   └── site/
│       ├── assets/
│       │   ├── css/
│       │   ├── img/
│       │   └── js/
│       └── views/
│           ├── 404.html
│           ├── base.html
│           ├── index.html
│           ├── topo.html
│           ├── rodape.html
│           └── sobre.html
│
└── vendor/                
```