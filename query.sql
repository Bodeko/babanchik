CREATE DATABASE freelance;
USE freelance;

CREATE TABLE Participant(
                            id INT AUTO_INCREMENT PRIMARY KEY ,
                            first_name VARCHAR(32) NOT NULL,
                            last_name VARCHAR(32) NOT NULL,
                            role ENUM('client', 'contractor'),
                            image_data MEDIUMBLOB,
                            login VARCHAR(32) UNIQUE,
                            hash VARCHAR(80) NOT NULL,
                            session_secret VARCHAR(80),
                            info TEXT
);

CREATE TABLE ProjectType(
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            title VARCHAR(64) NOT NULL UNIQUE
);
CREATE TABLE Project(
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        title TINYTEXT NOT NULL,
                        description TEXT NOT NULL,
                        client_id INT NOT NULL,
                        FOREIGN KEY (client_id) REFERENCES Participant(id),
                        contractor_id INT,
                        FOREIGN KEY (contractor_id) REFERENCES Participant(id),
                        projecttype_id INT,
                        FOREIGN KEY (projecttype_id) REFERENCES ProjectType(id),
                        sent_time DATETIME,
                        completed BOOL,
                        price DECIMAL check ( price > 0.01 )
);

CREATE TABLE Commentary(
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           participant_id INT NOT NULL,
                           FOREIGN KEY (participant_id) REFERENCES Participant(id),
                           project_id INT NOT NULL,
                           FOREIGN KEY (project_id) REFERENCES Project(id) ON DELETE CASCADE,
                           text_data TEXT NOT NULL,
                           sent_time TIMESTAMP
);

INSERT INTO `ProjectType` (`title`) VALUES ('Дизайн та арт');
INSERT INTO `ProjectType` (`title`) VALUES ('Програмування');
INSERT INTO `ProjectType` (`title`) VALUES ('Послуги');
INSERT INTO `ProjectType` (`title`) VALUES ('Аудіо та відео');
INSERT INTO `ProjectType` (`title`) VALUES ('Просування');
INSERT INTO `ProjectType` (`title`) VALUES ('Архітектура та інжиніринг');
INSERT INTO `ProjectType` (`title`) VALUES ('Мобільні додатки');
INSERT INTO `ProjectType` (`title`) VALUES ('Адміністрування');
INSERT INTO `ProjectType` (`title`) VALUES ('Аутсорсинг та консалтинг');
INSERT INTO `ProjectType` (`title`) VALUES ('Переклади');
INSERT INTO `ProjectType` (`title`) VALUES ('Робота з текстами');
INSERT INTO `ProjectType` (`title`) VALUES ('3D-моделювання');
INSERT INTO `ProjectType` (`title`) VALUES ('Додрукарська підготовка');

ALTER TABLE Project
    MODIFY COLUMN completed BOOL DEFAULT FALSE;

ALTER TABLE Participant MODIFY image_data BOOL DEFAULT FALSE;
UPDATE Participant SET image_data = 0 WHERE ISNULL(image_data);

CREATE TABLE ParticipantsTypes
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    participant_id INT NOT NULL REFERENCES Participant(id),
    projecttype_id INT NOT NULL REFERENCES ProjectType(id)

);