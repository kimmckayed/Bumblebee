BEGIN
  	DECLARE membership_id INT;
    SET membership_id = 1;
    WHILE (membership_id >= 1 and membership_id <= 10000) DO
          
        SET @random_code = FLOOR(RAND() * 9999999999);
        IF (NOT EXISTS (SELECT code FROM applegreen_codes WHERE code = @random_code))
        THEN
            	INSERT INTO applegreen_codes(id,applegreen_membership_id, code) VALUES(membership_id,CONCAT('APPLEGREEN-',convert(membership_id,CHAR(16))), @random_code);
                SET membership_id = membership_id + 1;
        END IF;
                                 
    END WHILE;
END