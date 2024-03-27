import { useRef } from "react";

import { Header } from "./Header";
import { NowPlaying } from "./NowPlaying/NowPlaying";

export function Layout() {
  const mainContainer = useRef<HTMLDivElement>(null);

  return (
    <div className="flex h-dvh w-full flex-col">
      <Header />
      <main className="h-full overflow-y-auto px-4 py-8" ref={mainContainer}>
        <NowPlaying scrollableContainerRef={mainContainer} />
      </main>
    </div>
  );
}
