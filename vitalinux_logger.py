import mariadb
import sys
import tkinter as tk
from tkinter import simpledialog, messagebox
# from datetime import datetime
import socket
import getpass

# Database connection function
def connect_to_db():
    try:
        conn = mariadb.connect(
            user="dbmanager",
            password="esa25",
            host="192.168.4.240",
            port=3306,
            database="incidents"
        )
        return conn
    except mariadb.Error as e:
        print(f"Error connecting to MariaDB Platform: {e}")
        return None

# Insert log into database
def insert_log(hostname, user, incident):
    conn = connect_to_db()
    if conn is None:
        print("Database connection failed. Cannot insert log.")
        return

    cur = conn.cursor()
    try:
        # Don't include log_time in the query
        query = "INSERT INTO incident_logs (hostname, user, incident) VALUES (%s, %s, %s)"
        #log_time = datetime.now()  # Current timestamp
        cur.execute(query, (hostname, user, incident))
        conn.commit()
        print("Log inserted successfully.")
    except mariadb.Error as e:
        print(f"Error inserting log: {e}")
    finally:
        cur.close()
        conn.close()

# Main question dialog with the user
def show_question_box():
    root = tk.Tk()
    root.withdraw()  # Hide the root window

    # Get the hostname and current user
    hostname = socket.gethostname()
    user = getpass.getuser()

    # Ask the main question
    answer = messagebox.askyesno("System Check", "Have you experienced any problems with this computer?")

    if answer:  # If the user clicks "Yes"
        # Ask for problem details
        problem_details = simpledialog.askstring("Problem Details", "Please describe the problem:")
        if problem_details and problem_details.strip():
            # Log the response into the database
            insert_log(hostname, user, problem_details.strip())
            messagebox.showinfo("Thank You", "Your issue has been recorded.")
        else:
            messagebox.showinfo("Error", "Problem description cannot be empty.")
    else:
        messagebox.showinfo("Thank You", "Glad to hear everything is working fine!")

    root.destroy()  # Close the Tkinter window

# Entry point for execution
if __name__ == "__main__":
    show_question_box()
