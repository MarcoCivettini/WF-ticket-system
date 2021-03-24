ORM => Doctrine
Framework => Symfony
DB => mysql
PHP => 8

start dev server
php -S 127.0.0.1:8080 -t public

Schema update
php bin/console doctrine:schema:update --force

Data seeding

database populated
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