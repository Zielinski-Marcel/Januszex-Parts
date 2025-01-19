export default function Alert({text, closeAlert}){
    return(
        <div className={`fixed top-0 left-0 flex p-2 w-full transition-all ${!text?"-translate-y-16" : "translate-y-0" }`}>
            <div className={"bg-primary text-white text-center p-4 box-border w-full relative"}>
                {text}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2}
                     stroke="currentColor" className="size-6 absolute right-4 top-4 hover:scale-125 transition-all active:scale-75" onClick={closeAlert}>
                    <path strokeLinecap="round" strokeLinejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </div>
        </div>
    )
}
