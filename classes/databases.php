<?php

namespace Classes;

class Databases
{
    public static function createDatabase()
    {
        $servername = "localhost";
        $username = "root";
        $password = "1234@Abcd";
        $conn = mysqli_connect($servername, $username, $password);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $createDatabase = "CREATE DATABASE library";
        mysqli_query($conn, $createDatabase);

        if (!$conn = Databases::database()) {
            die("Connection failed: " . $conn->connect_error);
        }

        $tables = [
            "CREATE TABLE Authors (Id INT NOT NULL AUTO_INCREMENT, Name VARCHAR(70) NOT NULL,PRIMARY KEY(Id));",
            "CREATE TABLE Books (Id INT NOT NULL AUTO_INCREMENT, Title VARCHAR(50) NOT NULL, PRIMARY KEY(Id));",
            "CREATE TABLE BooksAuthors (AuthorId INT NOT NULL,BookId  INT NOT NULL,FOREIGN KEY (AuthorId) REFERENCES Authors(Id),FOREIGN KEY (BookId) REFERENCES Books(Id));",
            "CREATE TABLE Users (Id INT NOT NULL AUTO_INCREMENT, User VARCHAR(50) NOT NULL, PRIMARY KEY(Id));",
            "CREATE TABLE StartTime (Id INT NOT NULL AUTO_INCREMENT, Start  TIMESTAMP, PRIMARY KEY(Id));",
            "CREATE TABLE EndTime (Id INT NOT NULL AUTO_INCREMENT,  End TIMESTAMP, PRIMARY KEY(Id));",
            "CREATE TABLE UsersBooks (UserId INT NOT NULL, BookId INT NOT NULL, StartTimeId INT NOT NULL, EndTimeId INT NOT NULL,FOREIGN KEY (UserId) REFERENCES Users(Id),FOREIGN KEY (BookId) REFERENCES Books(Id),FOREIGN KEY (StartTimeId) REFERENCES StartTime(Id), FOREIGN KEY (EndTimeId) REFERENCES EndTime(Id));",
        ];

        foreach ($tables as $table) {
            $conn->query($table);
        }
        if (!empty($table)) {
            foreach (Databases::dataAuthors() as $author) {
                $data = "insert into Authors (Name) VALUES ('$author')";
                Databases::connect($data);
            }
            foreach (Databases::dataBooks() as $book) {
                $data = "insert into Books (Title) VALUES ('$book')";
                Databases::connect($data);
            }
            foreach (Databases::bookAuthorId() as $key => $value) {
                $data = [
                    "insert into BooksAuthors (BookId, AuthorId) VALUES ('$value','$key')"
                ];
                foreach ($data as $info) {
                    Databases::connect($info);
                }
            }
            foreach (Databases::users() as $user) {
                $data = "insert into Users (User) VALUES ('$user')";
                Databases::connect($data);
            }
            foreach (Databases::start() as $start) {
                $data = "insert into StartTime (Start) VALUES ('$start')";
                Databases::connect($data);
            }
            foreach (Databases::end() as $end) {
                $data = "insert into EndTime (End) VALUES ('$end')";
                Databases::connect($data);
            }
            Databases::selectUserBook();
            $conn->close();
        }
    }

    public static function database()
    {
        return mysqli_connect(
            'localhost',
            'root',
            '1234@Abcd',
            'library');
    }

    public static function dataAuthors()
    {
        return
            [
                'J.D. Salinger',
                'F. Scott. Fitzgerald',
                'Jane Austen',
                'Scott Hanselman',
                'Jason N. Gaylord',
                'Pranav Rastogi',
                'Todd Miranda',
                'Christian Wenz'
            ];
    }

    public static function dataBooks()
    {
        return
            [
                'book1',
                'book2',
                'book3',
                'book4',
                'book5',
                'book6',
                'book7',
                'book8'
            ];
    }

    public static function bookAuthorId()
    {
        return
            [
                1 => 1,
                2 => 1,
                3 => 1,
                4 => 2,
                5 => 2,
                6 => 3,
                7 => 4,
                8 => 5
            ];
    }

    public static function users()
    {
        return
            [
                'user1',
                'user2',
                'user3',
                'user4',
                'user5',
                'user6',
                'user7',
                'user8'
            ];
    }

    public static function start()
    {
        return
            [
                '2022-06-12 00:00:01',
                '2022-06-12 00:00:02',
                '2022-06-12 00:00:03',
                '2022-06-12 00:00:04',
                '2022-06-12 00:00:05',
                '2022-06-12 00:00:06',
                '2022-06-12 00:00:08',
                '2022-06-12 00:00:09'
            ];
    }

    public static function end()
    {
        return
            [
                '2022-06-12 00:00:01',
                '2022-06-13 00:01:02',
                '2022-06-14 00:02:01',
                '2022-06-15 00:03:01',
                '2022-06-16 00:04:01',
                '2022-06-17 00:07:01',
                '2022-06-21 00:08:01',
                '2022-06-20 00:09:01',
            ];
    }

    public static function connect($data)
    {

        $conn = Databases::database();
        if ($conn->query($data) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $data . "<br>" . $conn->error;
        }
        return $data;
    }

    public static function select()
    {
        $data = [
            "SELECT ba.AuthorId,a.Name AuthorName,ba.BookId,b.Title BookTitle FROM BooksAuthors ba INNER JOIN Authors a ON a.id = ba.authorid INNER JOIN Books b ON b.id = ba.bookid;",
            "SELECT COUNT(*) AS `count_authors_of_exactly_one_book` FROM ( SELECT b.BookId FROM BooksAuthors b GROUP BY b.BookId HAVING COUNT(1) = 1) c",
            "SELECT COUNT(*) FROM ( SELECT b.BookId FROM BooksAuthors b GROUP BY b.BookId HAVING COUNT(1) <= 3) c"
        ];
        foreach ($data as $key) {
            Databases::connect($key);
        }

    }

    public static function deleteBook()
    {
        $delete = "DELETE FROM BooksAuthors WHERE AuthorId  IN (6,5);";
    }

    public static function selectUserBook()
    {
        $sql = [
            "SELECT id FROM Users",
            "SELECT id FROM Books",
            "SELECT id FROM StartTime",
            "SELECT id FROM EndTime",

        ];
        $conn = Databases::database();
        $i = 0;
        foreach ($sql as $select) {
            if ($result = mysqli_query($conn, $select)) {
                foreach ($result as $row) {
                    $i++;
                    $userId = $row['id'];
                    $booksId = $row['id'];
                    $startId = $row['id'];
                    $endId = $row['id'];
                    if ($i <= 8) {
                        $data = [
                            "insert into UsersBooks (UserId, BookId, StartTimeId, EndTimeId) VALUES ('$userId','$booksId','$startId','$endId')"
                        ];
                        foreach ($data as $info) {
                            Databases::connect($info);
                        }
                    }
                }
                mysqli_free_result($result);
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }

}