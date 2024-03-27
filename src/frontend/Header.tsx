import { ModeToggle } from "@/components/DarkMode/mode-toggle";

export function Header() {
  return (
    <header className="relative h-14 border-b bg-gray-100 dark:bg-gray-800">
      <div className="absolute top-1 h-14 w-full px-4 py-2 text-center md:top-0 md:text-left">
        <div className="font-serif text-2xl tracking-widest drop-shadow-[0_2px_3px_rgba(64,64,64,1)] md:text-4xl md:font-semibold dark:text-white dark:drop-shadow-[0_2px_3px_rgba(192,192,192,1)]">
          砕月
        </div>
      </div>
      <div className="absolute right-2 top-2">
        <ModeToggle />
      </div>
    </header>
  );
}
