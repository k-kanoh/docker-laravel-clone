import { ModeToggle } from "@/components/DarkMode/mode-toggle";

export function Header() {
  return (
    <header className="relative min-h-14 border-b bg-gray-100 dark:bg-gray-800">
      <div className="flex size-full items-center justify-center px-4 sm:justify-start">
        <div className="font-serif text-2xl tracking-widest drop-shadow-[0_2px_3px_rgba(64,64,64,1)] sm:text-4xl sm:font-semibold dark:text-white dark:drop-shadow-[0_2px_3px_rgba(192,192,192,1)]">
          砕月
        </div>
      </div>
      <div className="absolute right-2 top-1/2 -translate-y-1/2">
        <ModeToggle />
      </div>
    </header>
  );
}
