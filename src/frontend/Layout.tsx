import { Header } from "./Header";
import { NowPlaying } from "./NowPlaying/NowPlaying";

export function Layout() {
  return (
    <div className="flex h-dvh w-full flex-col">
      <Header />
      <div className="h-full overflow-y-auto px-4 py-8">
        <NowPlaying />
      </div>
    </div>
  );
}
