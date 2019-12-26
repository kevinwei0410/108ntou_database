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

# 建立測試資料庫的SQL
## Create Tables
```sql
create table student_schedule (
  student_ID varchar(255),
  lecture_section varchar(255),
  instructor_name varchar(255) not null,
  course_name varchar(255) not null,
  course_credit numeric(1,0),
  semester varchar(255) not null,
  primary key (student_ID, lecture_section)
);
```

## Insert Data
```sql
insert into student_schedule values
('00665625', '105,106,107', 'Jeff', 'Database', 3, '1081'),
('00665625', '205,206,207', 'Veronica', 'Java', 3, '1081'),
('00665625', '502,503,504', 'Mark', 'AI', 3, '1081'),
('00633445', '105,106,107', 'Jeff', 'Database', 3, '1081'),
('00633445', '303,304,305', 'Sebastian', 'Kotlin', 3, '1081'),
('00633445', '202,203,204', 'Gabriel', 'Computer Vision', 3, '1081');
```