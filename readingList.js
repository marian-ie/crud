document.addEventListener("DOMContentLoaded", loadBooks);

function loadBooks() {
    fetch("../api/readingList_api.php")
    .then(response => response.json())
    .then(data => {
        let booksTableBody = document.getElementById("booksTableBody");
        booksTableBody.innerHTML = "";

        if (data.status === "success") {
            data.books.forEach(book => {
                const statusButtonClass = book.status === "Done" ? "status-done" : "status-pending";
                const statusText = book.status === "Done" ? "Done" : "Mark as Done";
                booksTableBody.innerHTML += `
                <tr>
                    <td>${book.book_id}</td>
                    <td>${book.book_name}</td>
                    <td>${book.author}</td>
                    <td>${book.genre}</td>
                    <td>${book.target_date}</td>
                    <td>
                        <button class="status-btn ${statusButtonClass}" onclick="changeStatus(${book.book_id}, '${book.status}', this)">${statusText}</button>
                    </td>
                    <td class="actions">
                        <button class="edit-btn" onclick="openUpdateModal(${book.book_id}, '${book.book_name}', 
                        '${book.author}', '${book.genre}', '${book.target_date}', '${book.status}')">Edit</button>
                        <button class="delete-btn" onclick="deleteBook(${book.book_id})">Delete</button>
                    </td>
                </tr>`;
            });
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error("Error fetching Books:", error));
}

function addBook() {
    let book_name = document.getElementById("book_name").value.trim();
    let author = document.getElementById("author").value.trim();
    let genre = document.querySelector('input[name="genre"]:checked');
    let target_date = document.getElementById("target_date").value.trim();
    let status = "Pending"; 
   
    if(!book_name || !author || !genre || !target_date) {
        alert("Please fill all the fields!");
        return;
    }

    fetch("../api/readingList_api.php", {
        method: "POST",
        body: JSON.stringify({
            book_name: book_name,
            author: author,
            genre: genre.value,
            target_date: target_date,
            status: status
        }),
        headers: { "Content-Type": "application/json"}
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        document.getElementById("book_name").value = "";
        document.getElementById("author").value = "";
        document.querySelectorAll('input[name="genre"]').forEach(radio => radio.checked = false);
        document.getElementById("target_date").value = "";
        closeAddBooksModal();
        loadBooks();
    })
    .catch(error => console.error("Error adding book", error));
}

function updateBook() {
    let book_id = document.getElementById("edit_book_id").value;
    let book_name = document.getElementById("edit_book_name").value.trim();
    let author = document.getElementById("edit_author").value.trim();
    let genre = document.querySelector('input[name="edit_genre"]:checked');
    let target_date = document.getElementById("edit_target_date").value.trim();
    let status = document.getElementById("edit_status").value;

    // Validation
    if(!book_name || !author || !genre || !target_date) {
        alert("Please fill all the fields!");
        return;
    }

    fetch("../api/readingList_api.php", {
        method: "PUT",
        body: JSON.stringify({
            book_id: book_id,
            book_name: book_name,
            author: author,
            genre: genre.value,
            target_date: target_date,
            status: status
        }),
        headers: {"Content-Type": "application/json"}
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        closeUpdateModal();
        loadBooks();
    })
    .catch(error => console.error("Error updating details", error));
}

function deleteBook(book_id) {
    if (confirm("Are you sure you want to delete this book?")) {
        fetch(`../api/readingList_api.php?book_id=${book_id}`, {
            method: "DELETE"
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            loadBooks();
        })
        .catch(error => console.error("Error deleting book", error));
    }
}

function changeStatus(book_id, currentStatus, buttonElement) {
    const newStatus = currentStatus === "Done" ? "Pending" : "Done";
    
    
    if (currentStatus === "Done" && !confirm("Are you sure you want to mark this book as unread?")) {
        return;
    }
    
    fetch("../api/readingList_api.php", {
        method: "PUT",
        body: JSON.stringify({
            book_id: book_id,
            status: newStatus,
            update_status_only: true
        }),
        headers: {"Content-Type": "application/json"}
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            
            if (newStatus === "Done") {
                buttonElement.textContent = "Done";
                buttonElement.classList.remove("status-pending");
                buttonElement.classList.add("status-done");
            } else {
                buttonElement.textContent = "Mark as Done";
                buttonElement.classList.remove("status-done");
                buttonElement.classList.add("status-pending");
            }
            
           
            buttonElement.setAttribute("onclick", `changeStatus(${book_id}, '${newStatus}', this)`);
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error("Error changing status", error));
}

function openAddBooksModal() {
    document.getElementById("addBooksModal").style.display = "flex";
}

function closeAddBooksModal() {
    document.getElementById("addBooksModal").style.display = "none";
}

function openUpdateModal(book_id, book_name, author, genre, target_date, status) {
    document.getElementById("edit_book_id").value = book_id;
    document.getElementById("edit_book_name").value = book_name;
    document.getElementById("edit_author").value = author;
    
    
    document.querySelectorAll('input[name="edit_genre"]').forEach(radio => {
        if (radio.value === genre) {
            radio.checked = true;
        }
    });
    
    document.getElementById("edit_target_date").value = target_date;
    document.getElementById("edit_status").value = status;

    document.getElementById("updateBooksModal").style.display = "flex";
}

function closeUpdateModal() {
    document.getElementById("updateBooksModal").style.display = "none";
}