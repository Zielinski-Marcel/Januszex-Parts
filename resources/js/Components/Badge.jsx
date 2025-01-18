import Show from "@/Components/Show.jsx";

export default function Badge({content, children}) {
    return(
        <div className="relative">
            {children}
            <Show when={!!content}>
                 <span className="absolute rounded-full py-1 px-1 text-xs font-medium grid place-items-center top-[4%] right-[2%] translate-x-2/4 -translate-y-2/4 bg-red-500 text-white min-w-[24px] min-h-[24px]">
                    {content}
                 </span>
            </Show>
        </div>
    )
}
