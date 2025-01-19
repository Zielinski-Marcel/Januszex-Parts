import IconButton from "@/Components/IconButton.jsx";
import React, {useState} from "react";
import Show from "@/Components/Show.jsx";
import {useDetectClickOutside} from "react-detect-click-outside";

export default function SortPanel({sortBy, setSortBy}) {
    const [showSortPanel, setSortPanel] = useState(false);

    const ref = useDetectClickOutside({ onTriggered: ()=>setSortPanel(false) });


    return (
        <div ref={ref}>
            <IconButton onClick={() => setSortPanel(!showSortPanel)} className="relative h-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     strokeWidth={2} stroke="currentColor" className="size-6">
                    <path strokeLinecap="round" strokeLinejoin="round"
                          d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5"/>
                </svg>
                <Show when={showSortPanel}>
                    <div onClick={(e) => e.stopPropagation()}
                         className="absolute top-12 right-0 bg-white border-2 p-2 border-primary text-black rounded-md min-h-30 min-w-60 py-4 cursor-default">
                        <h2 className="text-base font-medium text-gray-900 mb-2 cursor-default">Filter Types of Spendings</h2>
                        <select className="cursor-pointer border border-primary" value={sortBy} onChange={event => setSortBy(event.target.value)}>
                            <option className="cursor-pointer" value="newDate">Sort by the earliest date</option>
                            <option className="cursor-pointer" value="oldDate">Sort by the latest date</option>
                            <option className="cursor-pointer" value="priceLow">Sort by the lowest price</option>
                            <option className="cursor-pointer" value="priceHigh">Sort by the highest price</option>
                            <option className="cursor-pointer" value="type">Sort by type</option>
                        </select>
                    </div>
                </Show>
            </IconButton>
        </div>
    )
}
