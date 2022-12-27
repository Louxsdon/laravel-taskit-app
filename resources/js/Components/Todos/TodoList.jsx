import React from "react";
import Todo from "./Todo";

export default function TodoList({ todos, setEdit }) {
    return (
        <ul className="w-full">
            {todos.length < 1 ? (
                <p className="text-slate-300 font-bold mt-4 pb-4 text-lg">
                    No todo available now
                </p>
            ) : (
                todos.map((todoItem, i) => (
                    <Todo setEdit={setEdit} key={i} todoItem={todoItem} />
                ))
            )}
        </ul>
    );
}
