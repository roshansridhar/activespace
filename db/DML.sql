-- userinfo 

-- location
insert into location values (default,null,null,'central park','new york city','ny','usa');
insert into location values (default,null,null,'breakneck ridge','cold springs','ny','usa');
insert into location values (default,null,null,null,'montauk','ny','usa');
insert into events values (default,null,null,null,'key west','FL','usa');
insert into events values (default,null,null,null,'grand canyon','AZ','usa');

-- events
insert into events values (2,'Meditation in Central Park','2017-03-30 07:00:00',1,null);
insert into events values (1,'Hiking at Breakneck Ridge','2017-04-09 05:00:00',2,null);

-- diaryentry
insert into diaryentry('description',1,2,current_timestamp,'title',1,22);
insert into diaryentry('description',2,1,current_timestamp,'title',2,15);
insert into diaryentry('description',3,1,current_timestamp,'title',3,16);
insert into diaryentry('description',4,1,current_timestamp,'title',4,8);
insert into diaryentry('description',5,1,current_timestamp,'title',5,10);
insert into diaryentry('description',6,9,current_timestamp,'title',1,14);
insert into diaryentry('description',7,2,current_timestamp,'title',2,22);
insert into diaryentry('description',8,13,current_timestamp,'title',3,17);
insert into diaryentry('description',9,6,current_timestamp,'title',4,20);
insert into diaryentry('description',10,6,current_timestamp,'title',5,11);

-- diary comments
insert into diary_comments(1,'comment1',1,current_timestamp,1);
insert into diary_comments(2,'comment2',2,current_timestamp,4);
insert into diary_comments(3,'comment3',3,current_timestamp,3);
insert into diary_comments(4,'comment4',4,current_timestamp,6);
insert into diary_comments(5,'comment5',4,current_timestamp,7);
insert into diary_comments(6,'comment6',4,current_timestamp,8);
insert into diary_comments(7,'comment7',4,current_timestamp,9);
insert into diary_comments(8,'comment8',7,current_timestamp,11);
insert into diary_comments(9,'comment9',9,current_timestamp,12);
insert into diary_comments(10,'comment10',10,current_timestamp,12);
insert into diary_comments(11,'comment11',11,current_timestamp,4);
insert into diary_comments(12,'comment12',3,current_timestamp,6);

-- diary likes
insert into diary_likes(1,3,current_timestamp);
insert into diary_likes(2,1,current_timestamp);
insert into diary_likes(3,2,current_timestamp);
insert into diary_likes(4,1,current_timestamp);
insert into diary_likes(5,2,current_timestamp);
insert into diary_likes(6,8,current_timestamp);
insert into diary_likes(7,4,current_timestamp);
insert into diary_likes(8,7,current_timestamp);
insert into diary_likes(6,8,current_timestamp);
insert into diary_likes(6,4,current_timestamp);
insert into diary_likes(1,3,current_timestamp);
insert into diary_likes(1,1,current_timestamp);
insert into diary_likes(3,2,current_timestamp);
insert into diary_likes(3,3,current_timestamp);
insert into diary_likes(5,11,current_timestamp);
insert into diary_likes(3,5,current_timestamp);
insert into diary_likes(6,6,current_timestamp);
insert into diary_likes(6,3,current_timestamp);
insert into diary_likes(9,7,current_timestamp);
insert into diary_likes(9,9,current_timestamp);
insert into diary_likes(11,10,current_timestamp);
insert into diary_likes(11,11,current_timestamp);
insert into diary_likes(11,3,current_timestamp);

-- multimedia
insert into multimedia values(1,current_timestamp,NULL,'text1',1);
insert into multimedia values(2,current_timestamp,NULL,'text1',1);
insert into multimedia values(3,current_timestamp,NULL,'text1',7);
insert into multimedia values(4,current_timestamp,NULL,'text1',9);
insert into multimedia values(5,current_timestamp,NULL,'text1',2);
insert into multimedia values(6,current_timestamp,NULL,'text1',1);
insert into multimedia values(7,current_timestamp,NULL,'text1',4);
insert into multimedia values(8,current_timestamp,NULL,'text1',1);
insert into multimedia values(9,current_timestamp,NULL,'text1',3);
insert into multimedia values(10,current_timestamp,NULL,'text1',1);
insert into multimedia values(11,current_timestamp,NULL,'text1',6);
insert into multimedia values(12,current_timestamp,NULL,'text1',1);
insert into multimedia values(13,current_timestamp,NULL,'text1',8);
insert into multimedia values(14,current_timestamp,NULL,'text1',9);
insert into multimedia values(15,current_timestamp,NULL,'text1',1);
insert into multimedia values(16,current_timestamp,NULL,'text1',1);
insert into multimedia values(17,current_timestamp,NULL,'text1',13);
insert into multimedia values(18,current_timestamp,NULL,'text1',12);
insert into multimedia values(19,current_timestamp,NULL,'text1',3);
insert into multimedia values(20,current_timestamp,NULL,'text1',6);
insert into multimedia values(21,current_timestamp,NULL,'text1',5);
insert into multimedia values(22,current_timestamp,NULL,'text1',2);
insert into multimedia values(23,current_timestamp,NULL,'text1',4);
insert into multimedia values(24,current_timestamp,NULL,'text1',10);
