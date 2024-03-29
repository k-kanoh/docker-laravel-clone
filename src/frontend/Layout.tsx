import { useRef } from "react";

import { Header } from "./Header";
import { NowPlaying } from "./NowPlaying/NowPlaying";
import { PageProvider } from "./NowPlaying/providers/page-provider";

export function Layout() {
  const mainContainer = useRef<HTMLDivElement>(null);

  return (
    <div className="flex h-dvh w-full flex-col">
      <PageProvider onPageChanged={() => mainContainer.current?.scrollTo(0, 0)}>
        <Header />
        <main className="h-full overflow-y-auto px-4 py-8" ref={mainContainer}>
          <NowPlaying />
        </main>
      </PageProvider>
    </div>
  );
}
