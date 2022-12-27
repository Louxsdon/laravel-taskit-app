import TodoList from "@/Components/Todos/TodoList";
import { Inertia } from "@inertiajs/inertia";
import { useForm } from "@inertiajs/inertia-react";
import React, { useState } from "react";

export default function Todos({ todos }) {
    const [throttle, setThrottle] = useState(false);
    const [isEditing, setIsEditing] = useState(false);
    const [updatedTodo, setUpdatedTodo] = useState(null);
    const { errors, data, put, post, reset, processing, setData } = useForm({
        todo: "",
        finished: false,
    });

    // submit todo
    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("todos.create"), {
            onSuccess: !errors.todo ? reset() : null,
        });
    };

    // handle active todo for update
    const setTodoUpdate = (todo) => {
        setIsEditing(true);
        setUpdatedTodo(todo);

        const todoData = todos.find((item) => item.id === todo.id);

        setData({ todo: todoData.todo, finished: todoData.finished });
        console.log(data);
    };
    // reset editing states
    const resetEditingStates = () => {
        setIsEditing(false);
        setUpdatedTodo(null);
        reset();
    };

    // handle todo update
    const handleUpdate = (e) => {
        e.preventDefault();
        console.log(data);
        put(`/todos/${updatedTodo.id}`, {
            onSuccess: !errors.todo ? resetEditingStates() : null,
        });
    };

    // handle search
    const onSearch = (e) => {
        const field = e.target.name;
        const value = e.target.value;
        setData(field, value);
        if (throttle) return;
        setThrottle(true);

        setTimeout(() => {
            setThrottle(false);
            console.log("triggering search");
            Inertia.get(
                `/todos`,
                { filters: value },
                {
                    preserveState: true,
                    replace: true,
                }
            );
        }, 600);
    };

    return (
        <div className="w-[60%] lg:w-[30%] mx-auto mt-28 border border-slate-200 rounded-lg p-6">
            {/* Create Todo Form */}
            <h2 className="text-xl font-bold text-center mb-6">
                Taskwise Todos
            </h2>
            <form className="mx-auto ">
                <div className="flex">
                    {!isEditing && (
                        <input
                            onChange={onSearch}
                            className="w-[20%] transition-all focus:w-full mr-2 outline-none border  border-slate-200 focus:ring-0"
                            type="text"
                            placeholder="Search..."
                            name="filters"
                            value={data?.filters}
                            disabled={isEditing}
                        />
                    )}
                    <div className="flex w-full">
                        <input
                            onChange={(e) =>
                                setData(e.target.name, e.target.value)
                            }
                            className={`outline-none border w-full  border-slate-200 focus:ring-0 ${
                                data?.finished && "line-through"
                            }`}
                            type="text"
                            placeholder={
                                isEditing ? "Editing Todo" : "New Todo"
                            }
                            name="todo"
                            value={data.todo}
                        />
                        {isEditing ? (
                            <button
                                onClick={handleUpdate}
                                disabled={processing}
                                className="bg-orange-500 text-orange-50 px-6"
                            >
                                Update
                            </button>
                        ) : (
                            <button
                                onClick={handleSubmit}
                                className="bg-green-600 text-green-50 px-6"
                                disabled={processing}
                            >
                                Save
                            </button>
                        )}
                    </div>
                </div>
                {errors && (
                    <span className="text-red-500 text-sm">{errors.todo}</span>
                )}
            </form>

            {isEditing && (
                // todo update buttons
                <div className="flex mt-2">
                    <button
                        onClick={resetEditingStates}
                        className="bg-red-300 text-red-600 mr-2 px-1"
                    >
                        Cancel Update
                    </button>
                    <button
                        onClick={() => {
                            setData("finished", !data.finished);
                        }}
                        className="bg-green-300 text-green-700 px-1.5"
                    >
                        {data?.finished ? "Unchecked" : "Checked"}
                    </button>
                </div>
            )}
            <div className="mt-5 w-full">
                <h3 className="font-bold text-lg mb-3">Todos List</h3>
                <TodoList setEdit={setTodoUpdate} todos={todos} />
            </div>
        </div>
    );
}
