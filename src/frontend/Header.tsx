import { ModeToggle } from "@/components/DarkMode/mode-toggle";

export function Header() {
  return (
    <header className="flex h-max items-center justify-between border-b bg-gray-100 dark:bg-gray-800">
      <div className="mx-auto font-serif text-2xl tracking-widest drop-shadow-[0_2px_3px_rgba(64,64,64,1)] sm:mx-4 sm:text-4xl sm:font-semibold dark:text-white dark:drop-shadow-[0_2px_3px_rgba(192,192,192,1)]">
        砕月
      </div>
      <div className="m-2 sm:m-4">
        <ModeToggle />
      </div>
    </header>
  );
}
