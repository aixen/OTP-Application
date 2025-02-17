# OTP Verification System
## Installation
    - Requirements
        - PHP 8.2 or up
            - Laravel 10
        - MySQL 8.4
        - SMTP mailer
            - on this I use mailtrap for debugging purposes
    - Authentication
        - Email: demo@mail.com
        - Password: test12345
    - git clone https://github.com/Laradock/laradock.git
        - Using Laradock for developement with
            - nginx
            - workspace
            - php-fpm
            - redis
            - redis-webui
            - mysql
            - phpmyadmin *for viewing database
    - cp .env.example .env
    - cp nginx/sites/app.conf.example nginx/sites/test-otp.conf
    - docker-compose up -d nginx workspace php-fpm redis redis-webui mysql
    - docker-compose exec workspace bash
        - art migrate

    - update .env of application
        - APP_URL = otp.local
    - For Window go to
        - Windows/System32/drivers/etc
        - open host add.
            - 127.0.0.1 otp.local

    - now you can start the application with otp.local as demo.
## Testing
    - docker-compose exec workspace bash
    - cd <repository-directory>
    - art test --filter=OtpVerificationTest
## Assumptions
    - TODO:
        - SMS notification for the OTP verification
        - index in the database to handle hundreds of million data.
        - Queue for sending otp verification.
## Additional Features
    - Added Email Notification for the OTP verification.
    - Auto Delete OTP once verified
    - Delete existing OTP for new logged in users.
    - Unit Test for the functionality of the OTP verification
## Technical Decisions
    - Create Email Notification for the OTP for the video recording.