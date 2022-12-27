import { Inertia } from "@inertiajs/inertia";
import React from "react";

export default function Todo({ todoItem, setEdit }) {
    const deleteTodo = (id) => {
        Inertia.delete(`/todos/${id}`);
    };
    return (
        <li className=" flex justify-between py-2.5 border-t border-slate-200">
            <p
                className={`w-[80%] ${
                    todoItem.finished && "line-through text-slate-600"
                }`}
            >
                {" "}
                {todoItem.todo}
            </p>
            <div className="flex w-[20%] justify-evenly">
                <button
                    onClick={() => setEdit(todoItem)}
                    className="bg-blue-300 text-blue-600 px-1"
                >
                    Edit
                </button>
                <button
                    onClick={() => deleteTodo(todoItem.id)}
                    className="bg-red-300 text-red-600 px-1"
                >
                    Del
                </button>
            </div>
        </li>
    );
}
