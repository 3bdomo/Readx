![logo](https://github.com/3bdomo/Readx/assets/110763337/b14c9427-c36d-49ea-a196-2f8d9aa27787)


# Readx: Library Management System

## Overview

Readx is a comprehensive library management system that provides two main sections: the Admin section and the User section. Within the User section, there are four distinct subsections: Book, Graduation Project, Research, and Exams. Each subsection offers specific functionalities to cater to the needs of users and administrators in a library setting.

## Features

### User Section

1. **Book Section**:
   - View existing books in the library.
   - Read books online.
   - Access detailed information about each book, including descriptions, author details, and additional metadata.

2. **Graduation Project Section**:
   - Upload project ideas for review.
   - Check the status of project submissions (accepted or rejected).
   - View a comparative ranking of all submitted projects.

3. **Research Section**:
   - Browse and view research papers conducted within the faculty.
   
4. **Exams Section**:
   - Display and access all available exams.

### Admin Section

1. **Manage Books**:
   - Add, update, or delete book entries.

2. **Manage Graduation Projects**:
   - Upload, delete, and evaluate project ideas.
   - Accept or reject projects based on comparative analysis.

3. **Manage Research Papers**:
   - Oversee the research section, including uploading and organizing research papers.

4. **Manage Exams**:
   - Upload and organize exam materials.

5. **Belligerence Check**:
   - Evaluate the comparative ranking of graduation projects to make informed decisions.

## Technologies Used

- **Backend**: Laravel
- **Database**: MySQL

## Installation

To run this project locally, follow these steps:

1. **Clone the repository**:
   ```
   git clone https://github.com/3bdomo/Readx.git
   ```

2. **Navigate to the project directory**:
   ```
   cd Readx-library-system
   ```

3. **Install the dependencies using Composer**:
   ```
   composer install
   ```

4. **Set up the environment file**:
   ```
   cp .env.example .env
   ```

5. **Generate the application key**:
   ```
   php artisan key:generate
   ```

6. **Set up the database**:
   Update the `.env` file with your database credentials, then run:
   ```
   php artisan migrate
   ```

7. **Run the application**:
   ```
   php artisan serve
   ```

## Usage

1. **Register/Login**: Users must first register for an account or log in using their credentials to access the app.
2. **Navigate Sections**: Use the app to access the Book, Graduation Project, Research, and Exams sections.
3. **Upload Projects**: In the Graduation Project section, submit your project idea and await admin review.
4. **Browse Content**: Explore books, research papers, and exams available in the respective sections.

## Contributors

- **Abdulrahman Mohamed**
- **Al'aa Mohamed **

## Acknowledgments

Thank you to my doctors, peers, and friends for their support and guidance throughout this project.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---
