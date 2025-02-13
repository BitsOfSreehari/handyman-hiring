CREATE DATABASE handyman_db;

USE handyman_db;

CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    is_handyman BOOLEAN DEFAULT FALSE,
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE skills (
    skill_id INT PRIMARY KEY AUTO_INCREMENT,
    skill_name VARCHAR(75) UNIQUE NOT NULL
);

CREATE TABLE handyman_profiles (
    profile_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE NOT NULL,
    profile_picture_url VARCHAR(255),
    other_job VARCHAR(255),
    work_start_time TIME NOT NULL,
    work_end_time TIME NOT NULL,
    work_location VARCHAR(75) NOT NULL,
    profile_description VARCHAR(80) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE handyman_work_days (
    work_day_id INT PRIMARY KEY AUTO_INCREMENT,
    profile_id INT NOT NULL,
    day_of_week INT NOT NULL CHECK (day_of_week BETWEEN 0 AND 6),
    FOREIGN KEY (profile_id) REFERENCES handyman_profiles(profile_id)  ON DELETE CASCADE,
    CONSTRAINT unique_handyman_work_day UNIQUE (profile_id, day_of_week)
);

CREATE TABLE handyman_skills (
    handyman_skill_id INT PRIMARY KEY AUTO_INCREMENT,
    profile_id INT NOT NULL,
    skill_id INT NOT NULL,
    FOREIGN KEY (profile_id) REFERENCES handyman_profiles(profile_id) ON DELETE CASCADE,
    FOREIGN KEY (skill_id) REFERENCES skills(skill_id) ON DELETE CASCADE
);

CREATE TABLE handyman_rating (
    rating_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    profile_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (profile_id) REFERENCES handyman_profiles(profile_id) ON DELETE CASCADE,
    CONSTRAINT unique_user_profile_rating UNIQUE (user_id, profile_id)
);

-- CREATE TABLE admins (
--     admin_id INT PRIMARY KEY AUTO_INCREMENT,
--     user_id INT UNIQUE NOT NULL,
--     FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
-- );

