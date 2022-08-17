# kanboard-externalAuth
Kanboard Plugin to allow login from external DB.
This tool is meant to be as generic as possible.
Based on the fact that most web-services (Joomla, Wordpress, Nextcloud, ...) base their user management on a DB, it should be easy to link Kanboard to their DB to use their users' list.  

Everything is configurable easily through the admin panel and is fully flexible (I hope so).

# Features
## External DB
Easy connection to an external DB through basic informations (host, user, pwd, port, ...).
It allows you to use another user management to read users.

## Fully configurable through admin panel
The whole plugin is configurable through the admin panel.
Once it is installed, you won't have to open any file or edit any PHP file.

## User management
The plugin is meant to read a users list stored in another DB or table than the one in Kanboard.
It allows you to have a single user management done in your main web-app (website hosting, cloud, ...) and to have to user available in Kanboard

## Groups management
The plugin is meant to read a groups list stored in another DB.
It allows you to have a single group management in your main web-app and to use it in Kanboard without having to recreate all the groups in Kanboard.

## User+group mapping
This is a feature I really want but it is hypothetical. I am not sure Kanboard's plugin system allows me to do this.
This part is meant to manage the roles from another service. With this, you should be able to manage your users, groups and their roles in another web-app and use it in Kanboard.

## Session management
This part is meant to simply reuse the session of another app to have a kind of SSO for your users.
They will just log in the main app and then will be directly logged in Kandboard with the same account, groups and permissions.
If the user logs in Kanboard, it won't create the session for the other app (for now, see future features - Extended session support).

# Future features
## Extended DB support
To start easily, I only support MySQL and Postgres DB's with the libs PicoDb bundled in Kanboard.
To allow more flexibility, I will add the following DB's :
- MSsql
- MySQL certificate support
- SQlite

## Extended password mechanism support
To be compliant with more CMS and external services, I will soon list more password mechanism.
I have to read a few documentations first (Joomla, Wordpress, Nextcloud).
Feel free to suggest other services I should check.

## Extended session support
The current session support is a bit clumsy. It works with cookies name that may change or not work as intended.
I will, in the future, add support of session mechanism used in the same services listed before (Joomla, Wordpress, Nextcloud).
The objective is to create session in other apps when the user logs in Kanboard to create a SSO system.
Again, I'll have to read the documentations...
Feel free to suggest other services I should check.

## Multiple DB support
To be able to fetch users, groups, sessions and all through multiple services, I will add a way to manage multiple DB connections and session-manager connections.
