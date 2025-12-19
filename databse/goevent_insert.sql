USE goevent_db;


--  VENUES

INSERT INTO venues (image, name, capacity, facilities, location)
VALUES ('images/conventionImage.jpg', 'Oman Convention and Exhibition Centre', '3200 + 456',
        'Auditoriums, exhibition halls, ballrooms', 'Muscat, Oman');

INSERT INTO venues (image, name, capacity, facilities, location)
VALUES ('images/ComputerLab.jfif', 'SQU CS Building Lab', '30 PCs',
        'Computers, projector, high-speed internet', 'Sultan Qaboos University, Muscat');

INSERT INTO venues (image, name, capacity, facilities, location)
VALUES ('images/homeImage.jpg', 'University Hall', '500 seats',
        'Stage, sound system, projector', 'Muscat, Oman');

INSERT INTO venues (image, name, capacity, facilities, location)
VALUES ('images/conventionImage.jpg', 'Community Hall A', '200 seats',
        'Chairs, microphones, air conditioning', 'Al Khoudh, Muscat');

INSERT INTO venues (image, name, capacity, facilities, location)
VALUES ('images/homeImage.jpg', 'Outdoor Plaza', '1000 standing',
        'Open area, lighting, security', 'Muscat, Oman');



--  EVENTS

INSERT INTO events (image, name, category, date, time, venue, link)
VALUES ('images/conventionImage.jpg', 'Tech Innovators Conference 2025', 'Conference',
        'Nov 20', '09:00', 'Oman Convention and Exhibition Centre', 'event-details.html');

INSERT INTO events (image, name, category, date, time, venue, link)
VALUES ('images/ComputerLab.jfif', 'Web Development Workshop', 'Workshop',
        'Nov 25', '10:00', 'SQU CS Building Lab', 'event-details.html');

INSERT INTO events (image, name, category, date, time, venue, link)
VALUES ('images/ComputerLab.jfif', 'AI Awareness Talk', 'Seminar',
        'Dec 02', '12:00', 'University Hall', 'event-details.html');

INSERT INTO events (image, name, category, date, time, venue, link)
VALUES ('images/ComputerLab.jfif', 'Startup Networking Night', 'Networking',
        'Dec 05', '18:00', 'Community Hall A', 'event-details.html');

INSERT INTO events (image, name, category, date, time, venue, link)
VALUES ('images/homeImage.jpg', 'Campus Open Day', 'Campus',
        'Dec 10', '08:30', 'Outdoor Plaza', 'event-details.html');



-- BOOKINGS

INSERT INTO bookings (event, ticket_type, quantity, name, email)
VALUES ('Tech Innovators Conference 2025', 'VIP', 2,
        'Ahmed Al-Hinai', 'ahmed@gmail.com');

INSERT INTO bookings (event, ticket_type, quantity, name, email)
VALUES ('Web Development Workshop', 'Standard', 1,
        'Ali Al-Balushi', 'Ali@gmail.com');

INSERT INTO bookings (event, ticket_type, quantity, name, email)
VALUES ('AI Awareness Talk', 'Standard', 3,
        'Salim Al-Farsi', 'salim@gmail.com');

INSERT INTO bookings (event, ticket_type, quantity, name, email)
VALUES ('Startup Networking Night', 'VIP', 1,
        'Mohammed Al-Kindi', 'mohammed@gmail.com');

INSERT INTO bookings (event, ticket_type, quantity, name, email)
VALUES ('Campus Open Day', 'VIP', 1,
        'Khalid Al-Saadi', 'khalid@gmail.com');
