CREATE TABLE operation_systems (
  id smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  descr varchar(30) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '{"alias":"os"}';

CREATE TABLE browsers (
  id smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  descr varchar(30) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '{"alias":"br"}';

CREATE TABLE user_systems (
  id smallint(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  ip_address varchar(30) NOT NULL,
  browser_id smallint(5) UNSIGNED NOT NULL,
  operation_system_id smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT user_systems_fk1 FOREIGN KEY (browser_id)
  REFERENCES browsers (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT user_systems_fk2 FOREIGN KEY (operation_system_id)
  REFERENCES operation_systems (id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '{"alias":"us"}';

CREATE TABLE user_entrances (
  id smallint(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_system_id smallint(5) UNSIGNED NOT NULL,
  entrance_datatime datetime NOT NULL,
  prev_url varchar(126) NOT NULL,
  entrance_url varchar(126) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT user_entrances_fk1 FOREIGN KEY (user_system_id)
  REFERENCES user_systems (id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '{"alias":"ue"}';

INSERT INTO browsers(id, descr) VALUES(1, 'Opera');
INSERT INTO browsers(id, descr) VALUES(2, 'Mozilla Firefox');
INSERT INTO browsers(id, descr) VALUES(3, 'IE9');
INSERT INTO browsers(id, descr) VALUES(4, 'IE10');
INSERT INTO browsers(id, descr) VALUES(5, 'IE11');
INSERT INTO browsers(id, descr) VALUES(6, 'Chrome');

INSERT INTO operation_systems(id, descr) VALUES(1, 'widows7');
INSERT INTO operation_systems(id, descr) VALUES(2, 'widows8');
INSERT INTO operation_systems(id, descr) VALUES(3, 'widows10');
INSERT INTO operation_systems(id, descr) VALUES(4, 'linux');