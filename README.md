# Présentation

![Petite_ombre_mini](https://user-images.githubusercontent.com/94828283/170983197-c223ce8a-5015-40a4-a5c9-d3eaf0125071.jpg)

La cliente travaille dans l'événementiel, elle a besoin d’un site qui lui permettra de présenter la programmation des spectacles solidaires pour jeune public.
Les spectacles ont une visée éducative et ludique.

Ce projet à un caractère solidaire, car les spectacles sont reconnus comme étant d’utilité publique et c'est ce qui permet au entreprises de bénéficier d’un crédit d'impôt mécénat lorsqu’ils réservent un spectacle.
Certains spectacles sont interactifs et permettent aux enfants de participer sous forme d’atelier.

Ce catalogue est susceptible d'évoluer lorsque de nouveaux spectacles sont créés par les artistes.

# Table of Contents  

- [Présentation](#Présentation)
- [Objectifs](#objectifs)
- [Liste des technologies](#liste-des-technologies)
- [Arborescence graphique](#arborescence-graphique)
- [User Stories](#user-stories)
- [API](#api)
- [DEV](#dev)
 <a name="Présentation"/>
<a name="Objectifs"/>
<a name="Liste-des-technologies"/>
<a name="Arborescence-graphique"/>
<a name="User-Stories"/>
<a name="API"/>
<a name="DEV"/>

# Objectifs

- La programmatrice d’événements a besoin d’un site qui lui permettra de présenter la programmation des spectacles solidaires pour jeune public.

- Le catalogue est composé de 13 spectacles avec des caractéristiques techniques différentes qui doivent tous être présentés.

- Elle souhaiterait pouvoir ajouter, modifier et supprimer des spectacles en fonction de l'évolution de son catalogue.


# Liste des technologies
 - HTML5 :  Dernière version d’HTML (Hypertext Markup Langage), langage de balisage conçu pour représenter des pages web.
 - CSS3 : Dernière version de CSS (feuilles de style en cascade), langage de présentation et mise en page de documents HTLM et XML.
 - JWT Token (authentification / sécurité) : Il permet l'échange sécurisé de jetons entre plusieurs parties.
 - Nelmio : Il permet de générer unJWTe documentation pour nos API.
 - Symfony : C’est un ensemble de composants PHP ainsi qu'un framework MVC. Il fournit des fonctionnalités modulables et adaptables qui permettent de faciliter et d’accélérer le développement d'un site web.
 - PHP : (Hypertext Preprocessor) principalement utilisé pour produire des pages Web dynamiques via un serveur HTTP.

# Arborescence graphique

![image](https://user-images.githubusercontent.com/94828283/170984243-041a8222-9ca8-4cfb-b533-6c07fbd515c0.png)


# User Stories


En tant que | Je veux | Afin de (si besoin/nécessaire)
-- | -- | -- |
Admin | me connecter | accéder au back-office
Admin | ajouter un événement | afin de renouveler le catalogue du site
Admin | modifier un événement | afin de mettre à jour les spectacles
Admin | supprimer un événement | afin de retirer un spectacle du catalogue

# API 

sur le local écrire directement /api/doc exemple : http://localhost:8080/api/doc

![image](https://user-images.githubusercontent.com/94828283/170988778-d366090b-e3f4-423c-a8d6-be5089fc6d52.png)

 - Allez dans My App API Auth
 - cliquer sur le menu déroulant :

![image](https://user-images.githubusercontent.com/94828283/170988999-02d1d906-8721-4c1f-bb02-5b793498a718.png)

 - ensuite sur try it out, cela permet d'entrer un username et un password :

 ![image](https://user-images.githubusercontent.com/94828283/170989269-f36e55b5-6588-4bce-84a3-2201dc7aea20.png)
 
 - cliquer sur executer pour reçevoir le token :

![image](https://user-images.githubusercontent.com/94828283/170989462-3801f2f3-1ced-41ef-96b0-6314ed3ac451.png)


 - Retourner tout en haut de la page pour cliquer sur Authorize et coller le token : 

![image](https://user-images.githubusercontent.com/94828283/170989671-8d25cd07-4442-4eb2-b3c3-0127521bc18a.png)

 - les cadenas sont noir, vous avez accès au chemin de l'API :

![image](https://user-images.githubusercontent.com/94828283/170989969-a6788c4d-8207-4b12-b350-6dc6b030a126.png)


# DEV

  Développeur back end ayant participé au projet : 
  
  - Alain Santamaria en tant que Lead DevBack (github : @Al1Santa)
  - Brandon Alexandre en tant que Scrum Master (github : @Brazake)





