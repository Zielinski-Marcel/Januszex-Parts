import { useEffect } from "react";

export default function Alert({ text, closeAlert }) {
    useEffect(() => {
        if (text) {
            const timer = setTimeout(() => {
                closeAlert();
            }, 2000);

            return () => clearTimeout(timer);
        }
    }, [text, closeAlert]);

    return(
        <div className={`fixed top-0 flex justify-center w-full md:left-[calc(50vw-384px)] transition-all max-w-[768px] px-4 mt-[0.21rem] ${!text?"-translate-y-16" : "translate-y-0" }`}>
            <div className={"bg-primary text-white text-center p-4 box-border w-full relative rounded flex justify-center"}>
                {text}
                {/*<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2}*/}
                {/*     stroke="currentColor" className="size-6 absolute right-4 top-4 hover:scale-125 transition-all active:scale-75 cursor-pointer" onClick={closeAlert}>*/}
                    <path strokeLinecap="round" strokeLinejoin="round" d="M6 18 18 6M6 6l12 12"/>
                {/*</svg>*/}
            </div>
        </div>
    )
}
