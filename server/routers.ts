import { COOKIE_NAME } from "@shared/const";
import { getSessionCookieOptions } from "./_core/cookies";
import { systemRouter } from "./_core/systemRouter";
import { publicProcedure, router } from "./_core/trpc";

export const appRouter = router({
    // if you need to use socket.io, read and register route in server/_core/index.ts, all api should start with '/api/' so that the gateway can route correctly
  system: systemRouter,
  auth: router({
    me: publicProcedure.query(opts => opts.ctx.user),
    logout: publicProcedure.mutation(({ ctx }) => {
      const cookieOptions = getSessionCookieOptions(ctx.req);
      ctx.res.clearCookie(COOKIE_NAME, { ...cookieOptions, maxAge: -1 });
      return {
        success: true,
      } as const;
    }),
  }),

  products: router({
    list: publicProcedure.query(async () => {
      const { getAllProducts } = await import("./db");
      return getAllProducts();
    }),
    get: publicProcedure.input((input: any) => input.id as number).query(async (opts) => {
      const { getProductById } = await import("./db");
      return getProductById(opts.input);
    }),
    create: publicProcedure
      .input((input: any) => input as { name: string; description: string; image: string })
      .mutation(async (opts) => {
        const { createProduct } = await import("./db");
        return createProduct(opts.input);
      }),
  }),
});

export type AppRouter = typeof appRouter;
