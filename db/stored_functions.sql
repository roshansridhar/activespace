-- For Accepting Friendship
CREATE OR REPLACE FUNCTION accept_friendship(user1 integer, user2 integer) 
    RETURNS void AS $$
      BEGIN
     UPDATE  friendrelation SET friendship_status='2' WHERE action_user_id=user2 and user_one_id in (user1,user2) and user_two_id in (user1,user2);
    END;
    $$ LANGUAGE plpgsql;

-- For Adding Friendship
CREATE OR REPLACE FUNCTION add_friendship(user1 integer, user2 integer) 
    RETURNS void AS $$
      BEGIN
      INSERT INTO friendrelation VALUES (user1, user2,1,0,user1,current_timestamp,current_timestamp);
    END;
    $$ LANGUAGE plpgsql;
    

-- For Declining Friendship
CREATE OR REPLACE FUNCTION decline_friendship(user1 integer, user2 integer) 
    RETURNS void AS $$
      BEGIN
      DELETE from friendrelation  where user_one_id in (user1,user2) and user_two_id in (user1,user2);
    END;
    $$ LANGUAGE plpgsql;
    
    
-- For Uploading photos to profile
CREATE OR REPLACE FUNCTION upload_photos(character varchar(100),image varchar(50),userid integer) 
    RETURNS void AS $$
      BEGIN
      INSERT INTO multimedia(post_time,content,description,user_id) VALUES (current_timestamp,image,text,userid);
    END;
    $$ LANGUAGE plpgsql;

-- For uploading diary entries to profile
CREATE OR REPLACE FUNCTION upload_diary(diary_title varchar(100),diary_desc varchar(50),diary_media varchar(100),location integer, userid integer) 
    RETURNS void AS $$
      BEGIN
      INSERT INTO diaryentry(entry,user_id,diarytime,title,loc_id,multimedia) VALUES (diary_desc,userid,current_timestamp,diary_title,location,diary_media);
    END;
    $$ LANGUAGE plpgsql;
    
-- For uploading posts to profile
CREATE OR REPLACE FUNCTION upload_posts(user1 INTEGER,user2 INTEGER, description varchar(150))
    RETURNS void AS $$
      BEGIN
      INSERT INTO posts(poster_id, postee_id, content,post_time) VALUES (user1,user2,description,current_timestamp);
    END;
    $$ LANGUAGE plpgsql;
    

-- Adding location
CREATE OR REPLACE FUNCTION add_location(address1 VARCHAR(100), city1 VARCHAR(100),state1 VARCHAR(100), country1 VARCHAR(100))
    RETURNS void AS $$
      BEGIN
      INSERT INTO location(lat,lng,address,city,state,country) VALUES (NULL,NULL,address1,city1,state1,country1);
    END;
    $$ LANGUAGE plpgsql;
    

-- Adding likers
CREATE OR REPLACE FUNCTION add_diarylikers(user1 INTEGER, diary1 INTEGER)
    RETURNS void AS $$
      BEGIN
      INSERT INTO diary_likes(user_id, diary_id,like_time) VALUES (user1,diary1,current_timestamp);
    END;
    $$ LANGUAGE plpgsql;
    
-- Adding commenters
CREATE OR REPLACE FUNCTION add_diarycommenters(user1 INTEGER, diary1 INTEGER, text varchar(100))
    RETURNS void AS $$
       BEGIN
      INSERT INTO diary_comments(user_id,diary_id,comment_entry,comment_time) VALUES(userid,diaryid,text,current_timestamp);
    END;
    $$ LANGUAGE plpgsql;

-- Adding commenters
CREATE OR REPLACE FUNCTION add_diarycommenters(address1 VARCHAR(100), city1 VARCHAR(100),state1 VARCHAR(100), country1 VARCHAR(100))
    RETURNS void AS $$
      BEGIN
      INSERT INTO location(lat,lng,address,city,state,country) VALUES (NULL,NULL,address1,city1,state1,country1);
    END;
    $$ LANGUAGE plpgsql; 

-- UPLOAD DISPLAY PICTURE

    CREATE OR REPLACE FUNCTION upload_dp(image varchar(100),userid integer) 
    RETURNS void AS $$
      BEGIN
      UPDATE userinfo SET picture_medium=image WHERE user_id=userid;
    END;
    $$ LANGUAGE plpgsql;
    
-- TRIGGER AND STORED FUNCTION FOR FRIENDSHIP STATUS
CREATE OR REPLACE FUNCTION update_modified_column()	
RETURNS TRIGGER AS $$
BEGIN
    NEW.action_taken_time = now();
    RETURN NEW;	
END;
$$ language 'plpgsql';

CREATE TRIGGER update_customer_modtime BEFORE UPDATE ON friendrelation FOR EACH ROW EXECUTE PROCEDURE  update_modified_column();
