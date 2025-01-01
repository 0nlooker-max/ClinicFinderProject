
CREATE TABLE appointment
(
  appointment_id int(11)   NOT NULL AUTO_INCREMENT,
  date           DATE      NOT NULL,
  time           TIME      NOT NULL,
  status         VARCHAR   NOT NULL,
  created_at     TIMESTAMP NOT NULL,
  user_id        int(11)   NOT NULL,
  schedule_id    int(11)   NOT NULL,
  PRIMARY KEY (appointment_id)
);

CREATE TABLE available_schedule
(
  schedule_id int(11)     NOT NULL AUTO_INCREMENT,
  date        DATE        NOT NULL,
  start_time  TIME        NOT NULL,
  end_time    TIME        NOT NULL,
  slot_status varchar(50) NOT NULL,
  clinic_id   int(11)     NOT NULL,
  PRIMARY KEY (schedule_id)
);

CREATE TABLE clinics
(
  clinic_id    int(11)       NOT NULL AUTO_INCREMENT,
  name         varchar(100)  NOT NULL,
  address      varchar(100)  NOT NULL,
  latitude     DECIMAL(10,8) NOT NULL,
  longitude    decimal(10,8) NOT NULL,
  contac_info  varchar(100)  NOT NULL,
  services     TEXT          NOT NULL,
  availability varchar(50)   NOT NULL,
  status       varchar(100)  NOT NULL,
  created_at   TIMESTAMP     NOT NULL,
  PRIMARY KEY (clinic_id)
);

CREATE TABLE rating
(
  rating_id  int(11)   NOT NULL AUTO_INCREMENT,
  rating     int(11)   NOT NULL,
  created_at TIMESTAMP NOT NULL,
  user_id    int(11)   NOT NULL,
  clinic_id  int(11)   NOT NULL,
  review_id  int(11)   NOT NULL,
  PRIMARY KEY (rating_id)
);

CREATE TABLE review
(
  review_id  int(11)   NOT NULL AUTO_INCREMENT,
  review     TEXT      NOT NULL,
  created_at TIMESTAMP NOT NULL,
  user_id    int(11)   NOT NULL,
  clinic_id  int(11)   NOT NULL,
  PRIMARY KEY (review_id)
);

CREATE TABLE user
(
  user_id     int(11)      NOT NULL AUTO_INCREMENT,
  username    varchar(100) NOT NULL,
  firstname   varchar(100) NOT NULL,
  lastname    varchar(100) NOT NULL,
  facebookacc varchar(100) NULL     COMMENT 'optional',
  password    varchar(100) NOT NULL,
  email       varchar(100) NOT NULL,
  role        varchar(50)  NOT NULL,
  created_at  TIMESTAMP    NOT NULL,
  PRIMARY KEY (user_id)
);

ALTER TABLE review
  ADD CONSTRAINT FK_user_TO_review
    FOREIGN KEY (user_id)
    REFERENCES user (user_id);

ALTER TABLE review
  ADD CONSTRAINT FK_clinics_TO_review
    FOREIGN KEY (clinic_id)
    REFERENCES clinics (clinic_id);

ALTER TABLE appointment
  ADD CONSTRAINT FK_user_TO_appointment
    FOREIGN KEY (user_id)
    REFERENCES user (user_id);

ALTER TABLE available_schedule
  ADD CONSTRAINT FK_clinics_TO_available_schedule
    FOREIGN KEY (clinic_id)
    REFERENCES clinics (clinic_id);

ALTER TABLE appointment
  ADD CONSTRAINT FK_available_schedule_TO_appointment
    FOREIGN KEY (schedule_id)
    REFERENCES available_schedule (schedule_id);

ALTER TABLE rating
  ADD CONSTRAINT FK_user_TO_rating
    FOREIGN KEY (user_id)
    REFERENCES user (user_id);

ALTER TABLE rating
  ADD CONSTRAINT FK_clinics_TO_rating
    FOREIGN KEY (clinic_id)
    REFERENCES clinics (clinic_id);

ALTER TABLE rating
  ADD CONSTRAINT FK_review_TO_rating
    FOREIGN KEY (review_id)
    REFERENCES review (review_id);
