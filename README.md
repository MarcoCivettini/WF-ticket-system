# WebFormat ticket system #
*   ORM => Dictrine
*   Framework => Symfony
*   DB => mysql
*   PHP => 7.3.24

1. [x] Assegnare un task ad uno sviluppatore. 
2. [x] Rimuovere un task da uno sviluppatore. 
3. [x] Mostrare tutti i task "in elaborazione" di uno sviluppatore. 
4. [x] Mostrare il PM di riferimento di un DEV. 

## Web server ##

il server espone le seguenti api testabili facilmente tramite postman.

#### Assegnazione di un task ad un utente ####
```
PUT => http://127.0.0.1:8080/api/task/assign/{taskId}
```
Json payload
```
{
	"userId": 4
}
```

#### Rimozione di un task da un utente ####
```
DELETE => http://127.0.0.1:8080/api/task/remove/{userId}/{taskId}
```
#### Visualizzazione task in lavorazione da uno sviluppatore ####
```
GET => http://127.0.0.1:8080/api/task/user/{userId}
```
#### Visualizzare il PM di uno sviluppatore ####
```
GET => http://127.0.0.1:8080/api/user/pm/{userId}
```
#### Mostra l'eleco dei team con i loro sviluppatori ####
```
GET => http://127.0.0.1:8080/api/team
```

## Schema update ##
```
php bin/console doctrine:schema:update --force
```

## Schema update ##
```
php bin/console seeding
```

### Database after seeding ###
```
select * from user;
+----+----------+----------+---------+------+
| id | password | username | team_id | role |
+----+----------+----------+---------+------+
|  1 | password | Mario    |    NULL |    1 |
|  2 | password | Enrico   |       1 |    2 |
|  3 | password | Antonio  |       2 |    2 |
|  4 | password | Luca     |       1 |    3 |
|  5 | password | Mirco    |       2 |    3 |
+----+----------+----------+---------+------+
5 rows in set (0.00 sec)

mysql> select * from team;
+----+--------+
| id | name   |
+----+--------+
|  1 | Team 1 |
|  2 | Team 2 |
+----+--------+
2 rows in set (0.00 sec)

mysql> select * from project;
+----+---------+-----------+
| id | user_id | name      |
+----+---------+-----------+
|  1 |       3 | Project 1 |
|  2 |       2 | Project 2 |
+----+---------+-----------+
2 rows in set (0.00 sec)

mysql> select * from task;
+----+-------------------------------------+--------+---------------------+------------+
| id | description                         | status | deadline_date       | project_id |
+----+-------------------------------------+--------+---------------------+------------+
|  1 | Implement realtime chat with socket |      2 | 2021-03-29 20:17:41 |          1 |
|  2 | Create shopping cart feature        |      2 | 2021-03-23 00:00:00 |          2 |
+----+-------------------------------------+--------+---------------------+------------+
2 rows in set (0.00 sec)

mysql> select * from users_tasks;
+---------+---------+
| task_id | user_id |
+---------+---------+
|       1 |       4 |
|       1 |       5 |
|       2 |       4 |
+---------+---------+
3 rows in set (0.00 sec)
```
