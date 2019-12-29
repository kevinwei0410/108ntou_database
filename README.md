# 第十四組資料庫
資料庫的名稱請設為`DBGroup14`

## 組員名單
 - 00353044 高鈺家
 - 0066c027 魏資碩
 - 00757204 方啟德
 - 00757208 張仕熹

## Git工作流程
1. 進入git所追蹤的資料夾，通常是專案中的頂層資料夾。可以使用`git status`查看。
2. 從遠端版本庫「拉取」資料到本地端（`git pull`）。
3. 更改程式碼。
4. 告訴Git有哪些改變要加到這次的commit中（`git add`）。
5. 執行commit，寫comment說明這次改了什麼（`git commit`）。
6. 將commit後的版本推送到遠端版本庫中，讓其他協作者可以存取（`git push`）。

# 建立資料庫的SQL
## Create Tables
```sql
create table semester_course (
  lecture_section      varchar(255),
  course_name          varchar(255),
  instructor_name      varchar(255),
  course_credit        numeric(1,0),
  participant_limit    numeric(3,0),
  current_participant  numeric(3,0),
  semester             varchar(255),
  primary key (lecture_section, course_name, instructor_name)
);
```

```sql
create table student_course_history (
  student_ID       varchar(255),
  semester         varchar(255),
  course_name      varchar(255),
  instructor_name  varchar(255),
  course_credit    numeric(1,0),
  primary key (student_ID, semester, course_name)
);
```

```sql
create table student_total_credits (
  student_ID     varchar(255),
  department     varchar(255) not null,
  year           numeric(1,0) not null,
  class          varchar(1) not null,
  semester       varchar(255),
  total_credits  numeric(3,0),
  average_score  numeric(4,2),
  rank           numeric(2,0),
  primary key (student_ID, semester) 
);
```

```sql
create table student_schedule (
  student_ID       varchar(255),
  lecture_section  varchar(255),
  course_name      varchar(255) not null,
  instructor_name  varchar(255) not null,
  course_credit    numeric(1,0),
  semester         varchar(255) not null,
  primary key (student_ID, lecture_section)
);
```

```sql
create table course_prerequisites (
  course_name  varchar(255) not null,
  pre_course1  varchar(255),
  pre_course2  varchar(255),
  pre_course3  varchar(255),
  primary key (course_name)
);
```

```sql
create table student_information (
  student_ID  varchar(255),
  password    varchar(255) not null,
  department  varchar(255) not null,
  year        numeric(1,0) not null,
  class       varchar(1) not null,
  primary key (student_ID)
);
```

## Foreign Keys
```sql
alter table student_course_history add constraint
  foreign key (student_ID, semester)
  references student_total_credits(student_ID, semester);
```

```sql
alter table student_schedule add constraint
  foreign key (lecture_section, course_name, instructor_name)
  references semester_course(lecture_section, course_name, instructor_name);
```

## Insert Data
```sql
insert into semester_course values
('105,106,107', 'Database', 'Jeff', 3, 100, 99, '1081'),
('205,206,207', 'Java', 'Veronica', 3, 40, 40, '1081'),
('502,503,504', 'AI', 'Mark', 3, 80, 80, '1081'),
('303,304,305', 'Kotlin', 'Sebastian', 3, 35, 35, '1081'),
('202,203,204', 'Computer Vision', 'Gabriel', 3, 80, 80, '1081');
```
```sql
insert into student_schedule values
('00665625', '105,106,107', 'Database', 'Jeff', 3, '1081'),
('00665625', '205,206,207', 'Java', 'Veronica', 3, '1081'),
('00665625', '502,503,504', 'AI', 'Mark', 3, '1081'),
('00633445', '105,106,107', 'Database', 'Jeff', 3, '1081'),
('00633445', '303,304,305', 'Kotlin', 'Sebastian', 3, '1081'),
('00633445', '202,203,204', 'Computer Vision', 'Gabriel', 3, '1081');
```
```sql
insert into student_total_credits values
('00665625', 'Computer Science', 3, 'B', '1081', 103, 95.70, 9),
('00633445', 'Computer Science', 3, 'A', '1081', 101, 86.10, 19),
('00663622', 'Computer Science', 3, 'B', '1081', 98, 94.87, 10),
('00752014', 'Computer Science', 2, 'A', '1081', 57, 66.66, 49),
('00641608', 'Computer Science', 3, 'A', '1081', 88, 74.25, 31),
('00533445', 'Computer Science', 4, 'B', '1081', 127, 89.33, 22),
('00733421', 'Physics', 2, 'A', '1081', 69, 91.30, 10),
('00733401', 'Physics', 2, 'B', '1081', 70, 88.52, 17);
```