CREATE TABLE users (
  id integer PRIMARY KEY AUTOINCREMENT NOT NULL,
  username char(255),
  password char(255),
  email char(128),
  role_id integer
);

CREATE TABLE roles (
  id integer PRIMARY KEY AUTOINCREMENT NOT NULL,
  name char(128)
);
