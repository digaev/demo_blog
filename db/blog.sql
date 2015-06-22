CREATE TABLE IF NOT EXISTS "users" (
    "id" integer primary key autoincrement not null,
    "email" varchar default "" not null,
    "username" varchar default "" not null,
    "password" varchar default "" not null,
    "created_at" datetime,
    "updated_at" datetime
);

CREATE TABLE IF NOT EXISTS "blogposts" (
    "id" integer primary key autoincrement not null,
    "user_id" integer not null,
    "title" varchar default "" not null,
    "body" text default "" not null,
    "created_at" datetime,
    "updated_at" datetime
);

CREATE TABLE IF NOT EXISTS "votes" (
    "id" integer primary key autoincrement not null,
    "user_id" integer not null,
    "blogpost_id" integer not null,
    "flag" boolean not null,
    "created_at" datetime,
    "updated_at" datetime
);
