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
        print(f"Error al conectarse a la plataforma MariaDB: {e}")
        return None

# Insert log into database
def insert_log(hostname, user, incident):
    conn = connect_to_db()
    if conn is None:
        print("Error en la conexión a la base de datos. No se puede insertar el registro.")
        return

    cur = conn.cursor()
    try:
        # Don't include log_time in the query
        query = "INSERT INTO incident_logs (hostname, user, incident) VALUES (%s, %s, %s)"
        #log_time = datetime.now()  # Current timestamp
        cur.execute(query, (hostname, user, incident))
        conn.commit()
        print("Registro insertado exitosamente.")
    except mariadb.Error as e:
        print(f"Error al insertar el registro: {e}")
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
    answer = messagebox.askyesno("Comprobación del sistema", "¿Has experimentado algún problema con este ordenador?")

    if answer:  # If the user clicks "Yes"
        # Create a custom dialog for problem details
        def get_problem_details():
            problem_details = text_field.get("1.0", tk.END).strip()  # Get text from the multi-line text field
            if problem_details:
                insert_log(hostname, user, problem_details)
                messagebox.showinfo("Gracias", "Su problema ha sido registrado")
                dialog.destroy()  # Close the custom dialog
            else:
                messagebox.showinfo("Error", "La descripción del problema no puede estar vacía")

        # Create a new window for the custom dialog
        dialog = tk.Toplevel(root)
        dialog.title("Detalles del problema")
        tk.Label(dialog, text="Por favor, describa el problema:").pack(pady=5)

        # Multi-line text field
        text_field = tk.Text(dialog, height=4, width=50)  # Set height to 4 lines
        text_field.pack(pady=5)

        # Submit button
        tk.Button(dialog, text="Enviar", command=get_problem_details).pack(pady=5)

        dialog.transient(root)  # Make the dialog modal
        dialog.grab_set()  # Prevent interaction with other windows
        root.wait_window(dialog)  # Wait for the dialog to close
    else:
        messagebox.showinfo("Gracias", "¡Me alegra saber que todo está funcionando bien!")


    root.destroy()  # Close the Tkinter window

# Entry point for execution
if __name__ == "__main__":
    show_question_box()
