CREATE DATABASE SUGANG;
USE SUGANG;

CREATE TABLE COURSE (
  OpenYear INTEGER,
  Semester VARCHAR(3),
  StudYear INTEGER,
  Type VARCHAR(10) NOT NULL,
  College VARCHAR(30),
  Department VARCHAR(30),
  CourseCode VARCHAR(12) NOT NULL,
  CourseName VARCHAR(30) NOT NULL,
  Credit INTEGER,
  Lecture INTEGER,
  Practice INTEGER,
  Lecturer VARCHAR(10),
  CourseTime1 VARCHAR(255),
  CourseTime2 VARCHAR(255),
  LectureBuilding VARCHAR(30),
  LectureRoom VARCHAR(10),
  StudQuota INTEGER,

  Primary key (CourseCode),
  UNIQUE (CourseCode)
);

CREATE TABLE STUDENT (
    StdName VARCHAR(10),
    StdNo VARCHAR(10),
    StdCollege VARCHAR(30),
    StdDepartment VARCHAR(30),

    PRIMARY KEY (StdNo),
    UNIQUE (StdNo)
);

CREATE TABLE COURSE_REGISTRATION (
    ReCourseNo VARCHAR(14),
    ReStdNo VARCHAR(10),
    FOREIGN KEY (ReCourseNo) REFERENCES COURSE(CourseCode) ON UPDATE CASCADE,
    FOREIGN KEY (ReStdNo) REFERENCES STUDENT(StdNo) ON UPDATE CASCADE,
    PRIMARY KEY (ReStdNo, ReCourseNo)
);

CREATE TABLE COURSE_SEARCHING (
    SearchCourseNo VARCHAR(14) NOT NULL ,
    SearchStdNo VARCHAR(10) NOT NULL ,

    FOREIGN KEY (SearchCourseNo) REFERENCES COURSE(CourseCode) ON UPDATE CASCADE ,
    FOREIGN KEY (SearchStdNo) REFERENCES STUDENT(StdNo) ON UPDATE CASCADE,
    PRIMARY KEY (SearchCourseNo, SearchStdNo)

);

-- Trigger to avoid registering for more than 3 Liberal Arts course
CREATE TRIGGER LIBERAL_COURSE_LIMIT BEFORE INSERT ON COURSE_REGISTRATION
    FOR EACH ROW BEGIN
    IF (SELECT count(*) FROM COURSE_REGISTRATION WHERE ReCourseNo LIKE 'CLTR%'
                    AND ReStdNo = NEW.ReStdNo GROUP BY ReStdNo ) > 2
        AND NEW.ReCourseNo LIKE 'CLTR%' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'ERROR: Reach the limitation for liberal arts course!';
        end if;
END;


-- Trigger to avoid registering for more than 24 credits
CREATE TRIGGER TOTAL_COURSE_LIMIT BEFORE INSERT ON COURSE_REGISTRATION
    FOR EACH ROW BEGIN
    IF (SELECT sum(credit) FROM COURSE, COURSE_REGISTRATION
        WHERE CourseCode = ReCourseNo AND ReStdNo = NEW.ReStdNo)
           + (SELECT Credit FROM COURSE WHERE CourseCode = NEW.ReCourseNo) > 24 THEN
        SIGNAL SQLSTATE '45001'
        SET MESSAGE_TEXT = 'ERROR: Reach the limitation of credit!';
        end if;
END;


-- Trigger to avoid exceeding number of students in class
CREATE TRIGGER LIMIT_STD_IN_CLASS BEFORE INSERT ON COURSE_REGISTRATION
    FOR EACH ROW BEGIN
    IF (SELECT count(*) FROM COURSE_REGISTRATION WHERE ReCourseNo = NEW.ReCourseNo) > 1 THEN
        SIGNAL SQLSTATE '45002'
        SET MESSAGE_TEXT = 'ERROR: Reach the limitation of student in class!';
    end if;
end;


-- Trigger to avoid registering for the same subject
CREATE TRIGGER DUPLICATE_SUBJECT BEFORE INSERT ON COURSE_REGISTRATION
    FOR EACH ROW BEGIN
    IF (SELECT CourseName FROM COURSE WHERE NEW.ReCourseNo = COURSE.CourseCode)
           IN (SELECT CourseName FROM COURSE WHERE CourseCode
                IN (SELECT ReCourseNo FROM COURSE_REGISTRATION WHERE NEW.ReStdNo = ReStdNo)) THEN
        SIGNAL SQLSTATE '45003'
        SET MESSAGE_TEXT = 'ERROR: You have already registered for that subject!';
end if;
end;


-- REQUEST: edit file path !!! or using phpMyAdmin (RECOMMENDED)
LOAD DATA INFILE '/Users/khangbuiphuoc/Sites/Sugang/data/COURSE.csv'
    INTO TABLE COURSE
    FIELDS TERMINATED BY ','
    LINES TERMINATED BY '\n'
    IGNORE 1 LINES;

-- Example Data
INSERT INTO STUDENT VALUES ('?????????', '2021117446', 'IT??????', '??????????????? ????????????????????????????????????');
INSERT INTO STUDENT VALUES ('?????????', '2022335667', 'IT??????', '??????????????? ????????????????????????????????????');
INSERT INTO STUDENT VALUES ('?????????', '2020211201', 'IT??????', '??????????????? ????????????????????????????????????');



-- Test suite:
-- Test #1: trigger LIBERAL_COURSE_LIMIT
INSERT INTO COURSE_REGISTRATION VALUES ('COME0331-006', '2021117446');
INSERT INTO COURSE_REGISTRATION VALUES ('COMP0204-001', '2021117446');
INSERT INTO COURSE_REGISTRATION VALUES ('COMP0216-002', '2021117446');
INSERT INTO COURSE_REGISTRATION VALUES ('CLTR0003-005', '2021117446');
INSERT INTO COURSE_REGISTRATION VALUES ('CLTR0043-007', '2021117446');
INSERT INTO COURSE_REGISTRATION VALUES ('CLTR0205-036', '2021117446');
INSERT INTO COURSE_REGISTRATION VALUES ('CLTR0089-004', '2021117446'); -- Expected result: error 45000

-- Test #2: trigger DUPLICATE_SUBJECT
INSERT INTO COURSE_REGISTRATION VALUES ('COME0331-007', '2021117446'); -- Expected result: error 45003

-- Test #3: trigger LIMIT_STD_IN_CLASS
INSERT INTO COURSE_REGISTRATION VALUES ('CLTR0205-036', '2020211201');
INSERT INTO COURSE_REGISTRATION VALUES ('CLTR0205-036', '2022335667'); -- Expected result: error 45002

-- Test 4: trigger TOTAL_COURSE_LIMIT
INSERT INTO COURSE_REGISTRATION VALUES ('COMP0224-003', '2021117446');
INSERT INTO COURSE_REGISTRATION VALUES ('COME0331-006', '2021117446'); -- Expected result: error 45001
