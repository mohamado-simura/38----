tasks = []

def show_tasks():
    if not tasks:
        print("\nNo tasks yet.")
    else:
        print("\nYour Tasks:")
        for i, task in enumerate(tasks, 1):
            print(f"{i}. {task}")

while True:
    print("\n--- TO-DO LIST ---")
    print("1. Add task")
    print("2. View tasks")
    print("3. Delete task")
    print("4. Quit")

    choice = input("Choose (1-4): ")

    if choice == "1":
        task = input("Enter task: ")
        tasks.append(task)
        print("Task added!")

    elif choice == "2":
        show_tasks()

    elif choice == "3":
        show_tasks()
        try:
            num = int(input("Task number to delete: "))
            removed = tasks.pop(num-1)
            print(f"Removed: {removed}")
        except:
            print("Invalid number")

    elif choice == "4":
        print("Goodbye!")
        break

    else:
        print("Invalid choice")
