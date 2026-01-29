CREATE DATABASE IF NOT EXISTS les_titans CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS les_titans_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

GRANT ALL PRIVILEGES ON les_titans.* TO 'symfony'@'%';
GRANT ALL PRIVILEGES ON les_titans_test.* TO 'symfony'@'%';

FLUSH PRIVILEGES;
